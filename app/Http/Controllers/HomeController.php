<?php

namespace App\Http\Controllers;

use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Customer\CustomerService;
use App\Services\Merchant\MerchantService;
use App\Services\Transaction\TransactionService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class HomeController extends Controller
{
    use ResponseTrait;
    protected $customerService;
    protected $transactionService;

    public function __construct(CustomerService $customerService, TransactionService $transactionService)
    {
        $this->customerService = $customerService;
        $this->transactionService = $transactionService;
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function index(): \Inertia\Response
    {
        $clientTransactionDTO = null;
        $customerInfo = $this->customerService->getCustomerInfo();

        if (session('trxId')) {
            $merTrxId = session('trxId');
            $clientTransactionDTO = $this->transactionService->getClientTransactionByTrxId($merTrxId);
        }

        return Inertia::render("Home", [
            'customerInfo' => $customerInfo,
            "clientTransactionDTO" => $clientTransactionDTO
        ]);
    }
}

?>
