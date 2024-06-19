<?php

namespace App\Http\Controllers\api;

use App\Exceptions\MegapayException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;
use App\Services\Transaction\TransactionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @throws MegapayException
     */
    public function mgpNotify(Request $request) {
        $this->logInfo(__METHOD__ . " callback");
        $requestData = $request->all();

        $this->transactionService->updateTransactionByMegapayData($requestData);

        return response()->json(['returnCode' => 200], Response::HTTP_OK);
    }
}
