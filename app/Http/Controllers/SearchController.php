<?php

namespace App\Http\Controllers;

use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Requests\Customer\SearchCustomerQrRequest;
use App\Http\Requests\Customer\SearchCustomerRequest;
use App\Services\Customer\CustomerService;
use App\Services\Merchant\MerchantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    protected $customerService;
    protected $merchantService;
    public function __construct(CustomerService $customerService, MerchantService $merchantService)
    {
        $this->customerService = $customerService;
        $this->merchantService = $merchantService;
    }

    public function index(): \Inertia\Response
    {
        $this->merchantService->setNewMerchantSession();

        return Inertia::render("Search", [
        ]);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws LogicException
     */
    public function search(SearchCustomerRequest $request): RedirectResponse
    {
        $contractNo = $request->input('contractNo');

        $merchantCode = $this->merchantService->getCurrentMerchantCode();

        $this->customerService->setNewCustomerSession($contractNo, $merchantCode);

        return response()->redirectToRoute("home.index");
    }

    /**
     * @throws LogicException
     * @throws ResourceNotFoundException
     */
    public function searchViaQR(SearchCustomerQrRequest $request): RedirectResponse
    {
        $token = $request->query('token');

        $merchantCode = $this->merchantService->getCurrentMerchantCode();

        $this->customerService->setNewCustomerSession($token, $merchantCode, true);

        return response()->redirectToRoute("home.index");
    }
}
