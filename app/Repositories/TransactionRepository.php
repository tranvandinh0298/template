<?php

namespace App\Repositories;

use App\Exceptions\CorePortalException;
use App\Exceptions\LogicException;
use App\Models\ClientTransaction;
use App\Repositories\DTOs\ClientTransactionDTO;
use App\Repositories\Interfaces\MerchantInterface;
use App\Repositories\Interfaces\TransactionInterface;
use App\Repositories\Mappers\ClientTransactionDetailMapper;
use App\Repositories\Mappers\ClientTransactionMapper;
use App\Repositories\Mappers\CustomerMapper;
use App\Traits\RequestCoreTrait;
use App\Traits\ResponseTrait;
use http\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements TransactionInterface
{
    use RequestCoreTrait;
    use ResponseTrait;

    public function __construct()
    {
        $this->endpoint = config("client.core.paying_bill_url");
    }

    /**
     * @throws LogicException
     */
    public function storeTransaction(ClientTransactionDTO $clientTransactionDTO): ClientTransactionDTO
    {
        $this->saveClientTransactionToLocalDB($clientTransactionDTO);

        $this->sendTransactionToCore($clientTransactionDTO);

        return $clientTransactionDTO;
    }

    public function getClientTransactionByTrxId($trxId): ?ClientTransactionDTO
    {
        $clientTransaction = ClientTransaction::with("clientTransactionDetails")->where("trx_id", $trxId)->first();
        $this->logInfo(__METHOD__ . " - clientTransaction: " . json_encode($clientTransaction));
        return $clientTransaction ? ClientTransactionMapper::toDTO($clientTransaction) : null;
    }

    protected function saveClientTransactionToLocalDB(ClientTransactionDTO $clientTransactionDTO): ClientTransaction
    {
        return DB::transaction(function () use ($clientTransactionDTO) {
            $clientTransaction = ClientTransactionMapper::toEntity($clientTransactionDTO);
            $clientTransaction->save();

            foreach ($clientTransactionDTO->clientTransactionDetailDTOs ?? [] as $clientDetailDTO) {
                $detail = null;
                $detail = ClientTransactionDetailMapper::toEntity($clientDetailDTO);
                $detail->transaction_id = $clientTransaction->id;
                $detail->save();
            }

            return $clientTransaction;
        });

    }

    public function updateTransaction(ClientTransactionDTO $clientTransDTO)
    {
        return DB::transaction(function () use ($clientTransDTO) {
            $clientTrans = ClientTransaction::find($clientTransDTO->id);

            $this->logInfo("CLIENT TRANS BEFORE: " . json_encode($clientTrans, 256));

            ClientTransactionMapper::updateFromDTO($clientTransDTO, $clientTrans);

            $this->logInfo("CLIENT TRANS AFTER: " . json_encode($clientTrans, 256));

            $clientTrans->save();

            $this->sendTransactionToCore($clientTransDTO);

            return $clientTrans;
        });
    }

    /**
     * @throws LogicException
     */
    private function sendTransactionToCore(ClientTransactionDTO $clientTransactionDTO): bool
    {
        $this->setPayingBillRequest($clientTransactionDTO);

        //        $response = Http::post($this->endpoint, $this->getRequestData());
//        $this->handleInvalidResponse($response);
//        $responseData = $response->json();
        $responseData = [
            "returnCode" => 200,
            "returnMessage" => "",
            "data" => [
                "transStatus" => 200,
                "transactionMessage" => "Transaction success!"
            ]
        ];

        if ($this->isResponseSuccess($responseData['returnCode']) && !empty($responseData['data'])) {
            return $this->handleSuccessResponse($responseData['data']);
        }

        return false;
    }

    /**
     * @throws LogicException
     */
    private function setPayingBillRequest(ClientTransactionDTO $clientTransactionDTO)
    {
        $requestId = $this->generateRequestId();

        $merchantId = strtoupper($clientTransactionDTO->merchantCode);

        $merchantSubId = !empty($clientTransactionDTO->subId) ? strtoupper($clientTransactionDTO->subId) : "";

        $billIds = collect($clientTransactionDTO->clientTransactionDetailDTOs)->map(function ($detail) {
            return $detail->billId;
        })->toArray();

        $methodId = $clientTransactionDTO->methodId;

        $trxId = $clientTransactionDTO->trxId;

        $mgpTrxId = $clientTransactionDTO->mgpId;

        $paymentFee = $clientTransactionDTO->totalAmount - $clientTransactionDTO->amount ?? 0;

        $fixedFee = $clientTransactionDTO->fixedFee;

        $percent = $clientTransactionDTO->ratedFee;

        $statusMGP = $clientTransactionDTO->mgpStatus ?? TRANS_STATUS_PENDING;

        $keyHash = $this->getPartnerKeyHash($merchantId);

        // signature
        $signature = bcrypt($requestId . $merchantId . $keyHash);

        $this->setRequestData([
            'requestId' => $requestId,
            'merchantId' => $merchantId,
            'merchantSubId' => $merchantSubId,
            'methodId' => $methodId,
            'statusMGP' => $statusMGP,
            'portalId' => $trxId,
            'trxRefund' => $mgpTrxId,
            'paymentFee' => $paymentFee,
            'fixedFee' => $fixedFee,
            'percent' => $percent,
            'cycleIds' => $billIds,
            'signature' => $signature,
        ]);
    }

    private function handleSuccessResponse($responseData): bool
    {
        return true;
    }
}
