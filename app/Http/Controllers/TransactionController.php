<?php

namespace App\Http\Controllers;

use App\Exceptions\MegapayException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\Transaction\ProcessMGPDataRequest;
use App\Services\Customer\CustomerService;
use App\Services\Transaction\TransactionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TransactionController extends Controller
{
    use ResponseTrait;
    protected $transactionService;
    protected $customerService;

    public function __construct(TransactionService $transactionService, CustomerService $customerService)
    {
        $this->transactionService = $transactionService;
        $this->customerService = $customerService;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function index(string $merTrxId): \Inertia\Response
    {
        $this->logInfo(__METHOD__ . " guide");
        $clientTransactionDTO =  $this->transactionService->getClientTransactionByTrxId($merTrxId);
        $customerDTO = $this->customerService->getCustomerInfo();
        return Inertia::render("Transaction", [
            'clientTransactionDTO' => $clientTransactionDTO,
            'customerInfo' => $customerDTO,
        ]);
    }

    /**
     * @throws MegapayException
     */
    public function processMegapayData(ProcessMGPDataRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $this->logInfo("CREATE MGP\'s TRANSACTION");

        $processedData = $this->transactionService->processData($requestData);

        return $this->successResponse($processedData);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws MegapayException
     */
    public function mgpResult (Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->logInfo(__METHOD__ . " callback");
        $requestData = $request->all();

        $trxId = $this->transactionService->updateTransactionByMegapayData($requestData);

        return redirect()->route("home.index")->with('trxId', $trxId);
    }
}
