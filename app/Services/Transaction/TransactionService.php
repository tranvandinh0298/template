<?php

namespace App\Services\Transaction;

use App\Exceptions\LogicException;
use App\Exceptions\MegapayException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\DTOs\ClientTransactionDetailDTO;
use App\Repositories\DTOs\ClientTransactionDTO;
use App\Repositories\TransactionRepository;
use App\Services\Bill\BillService;
use App\Services\Customer\CustomerService;
use App\Services\PaymentMethod\PaymentMethodService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Str;

class TransactionService
{
    use ResponseTrait;

    private $paymentMethodService;
    private $megapayService;
    private $billService;
    private $customerService;
    private $transactionRepository;

    public function __construct(
        PaymentMethodService  $paymentMethodService,
        MegapayService        $megapayService,
        BillService           $billService,
        CustomerService       $customerService,
        TransactionRepository $transactionRepository
    )
    {
        $this->paymentMethodService = $paymentMethodService;
        $this->megapayService = $megapayService;
        $this->billService = $billService;
        $this->customerService = $customerService;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @throws MegapayException
     * @throws LogicException
     */
    public function processData($requestData): array
    {
        $customerDTO = $this->customerService->getCustomerInfo();

        $billDTOs = $this->billService->getBillByIds($requestData['billIds']);

        $amount = 0;
        $goodsNm = [];
        foreach ($billDTOs as $bill) {
            $amount += $bill->amount;
            $goodsNm[] = $bill->name ?? $bill->date;
        }
        $goodsNm = Str::limit(collect($goodsNm)->join(","), 90);

        $calculateFee = $this->paymentMethodService->calculateFee($requestData['methodId'], $amount);

        $prepareDataToProcess = array_merge($calculateFee, [
            'contractNo' => $customerDTO->contractNo,
            'customerAddress' => $customerDTO->customerAddress,
            'customerName' => $customerDTO->customerName,
            'subId' => $customerDTO->merchantDTO->subId,
            'merchantCode' => $customerDTO->merchantDTO->merchantCode,
            'merchantFirstName' => $customerDTO->merchantDTO->firstName,
            'merchantLastName' => $customerDTO->merchantDTO->lastName,
            'goodsNm' => $goodsNm,
            'vaOption' => $customerDTO->merchantDTO->vaOption,
            'methodId' => $requestData['methodId'],
            'billDTOs' => $billDTOs
        ]);

        $megapayData = $this->megapayService->processMegapayData($prepareDataToProcess);

        $this->createClientTransaction(array_merge($prepareDataToProcess, $megapayData));

        return $megapayData;
    }

    /**
     * @throws LogicException
     */
    protected function createClientTransaction($transData): ClientTransactionDTO
    {
        $clientTransactionDetailDTOs = collect($transData['billDTOs'])->map(function ($bill) {
            return new ClientTransactionDetailDTO(
                null,
                null,
                $bill->id,
                $bill->name ?? $bill->date,
                $bill->amount,
                $bill->details,
            );
        })->toArray();

        $clientTransactionDTO = new ClientTransactionDTO(
            null,
            $transData['contractNo'],
            $transData['customerName'],
            $transData['customerAddress'],
            $transData['subId'],
            $transData['merchantCode'],
            $transData['merTrxId'],
            $transData['mgpId'] ?? null,
            $transData['originAmount'],
            $transData['fixedFee'],
            $transData['ratedFee'],
            $transData['totalAmount'],
            $transData['methodId'],
            $transData['status'] ?? TRANS_STATUS_PENDING,
            $transData['mgpStatus'] ?? TRANS_STATUS_PENDING,
            $transData['mgpMsg'] ?? null,
            null,
            $transData['mgpResponseCode'] ?? null,
            $transData['bankCode'] ?? null,
            $transData['bankName'] ?? null,
            $transData['vaNumber'] ?? null,
            $transData['vaName'] ?? null,
            $transData['vaStartDate'] ?? null,
            $transData['vaEndDate'] ?? null,
            $transData['vaQrCode'] ?? null,
            $transData['vaContent'] ?? null,
            $transData['note'] ?? null,
            null,
            null,
            $clientTransactionDetailDTOs
        );

        $this->logInfo(__METHOD__ . ' - CREATE TRANSACTION SUCCESSFULLY WITH DATA: ' . json_encode($clientTransactionDTO, 256));

        $this->transactionRepository->storeTransaction($clientTransactionDTO);

        return $clientTransactionDTO;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function getClientTransactionByTrxId($merTrxId): ?ClientTransactionDTO
    {
        $this->logInfo(__METHOD__. " - merTrxId: ". $merTrxId);

        $transactionDTO = $this->transactionRepository->getClientTransactionByTrxId($merTrxId);

        $this->logInfo(__METHOD__. " - ". json_encode($transactionDTO));

        $transactionDTO->paymentMethodDTO = $this->paymentMethodService->getPaymentMethodById($transactionDTO->methodId);

        $this->throwIfNotFoundResource($transactionDTO, __("messages.client_transaction.not_found"));

        return $transactionDTO;
    }

    /**
     * @throws MegapayException
     * @throws ResourceNotFoundException
     */
    public function updateTransactionByMegapayData($mgpData): string
    {
        $convertData = $this->megapayService->handleResult($mgpData);

        $clientTransactionDTO = $this->getClientTransactionByTrxId($convertData['merTrxId']);

        $this->logInfo("UPDATE TRANSACTION - MERTRXID: " . $convertData['merTrxId'] . " - WITH DATA: " . json_encode($convertData, 256));

        $this->logInfo("CLIENT TRANSACTION DTO BEFORE: " . json_encode($clientTransactionDTO, 256));

        $this->updateClientTransactionDTOFields($clientTransactionDTO, $convertData);

        $this->logInfo("CLIENT TRANSACTION DTO AFTER: " . json_encode($clientTransactionDTO, 256));

        $this->transactionRepository->updateTransaction($clientTransactionDTO);

        if ($clientTransactionDTO->isTransactionSuccess()) {
            $this->billService->updateBillStatusSuccess($this->getClientTransactionBillIds($clientTransactionDTO));
        }

        return $convertData['merTrxId'];
    }

    protected function updateClientTransactionDTOFields(ClientTransactionDTO $clientTransDTO, $transData)
    {
        $this->logInfo('ALLOWED_UPDATE_TRANSACTION_FIELDS: '. json_encode(ALLOWED_UPDATE_TRANSACTION_FIELDS));
        foreach (ALLOWED_UPDATE_TRANSACTION_FIELDS as $field) {
            $this->updateFields($clientTransDTO, $field, $transData);
        }
    }

    protected function updateFields(ClientTransactionDTO $clientTransDTO, $field, $transData)
    {
        if (empty($clientTransDTO->{$field}) && !empty($transData[$field])) {
            $clientTransDTO->{$field} = $transData[$field];
        }
    }

    protected function getClientTransactionBillIds(ClientTransactionDTO $clientTransactionDTO): array
    {
        return collect($clientTransactionDTO->clientTransactionDetailDTOs)->pluck("billId")->toArray();
    }
}
