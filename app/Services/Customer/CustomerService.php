<?php

namespace App\Services\Customer;

use App\Exceptions\CorePortalException;
use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\CustomerRepository;
use App\Repositories\DTOs\CustomerDTO;
use App\Services\Bill\BillService;
use App\Services\Merchant\MerchantService;
use App\Traits\ResponseTrait;
use App\Traits\SecurityTrait;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    use ResponseTrait;
    use SecurityTrait;
    private $customerSessionService;
    private $customerRepository;

    public function __construct(
        CustomerSessionService $customerSessionService,
        CustomerRepository $customerRepository
    ) {
        $this->customerSessionService = $customerSessionService;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws LogicException
     * @throws ResourceNotFoundException
     */
    public function setNewCustomerSession($contractNo, $merchantCode, $isQRRequest = false): ?CustomerDTO
    {
        if ($isQRRequest) {
            $contractNo = $this->processQRToken($contractNo, $merchantCode);
        }

        $customer = $this->getCustomerByContractNo($contractNo, ['merchantCode' => $merchantCode]);

        $this->customerSessionService->setNewSession($customer);

        return $customer;
    }

    public function updateCustomerSession($customerSession) {
        $this->customerSessionService->setNewSession($customerSession);

        return $customerSession;
    }

    public function isCustomerSessionExists(): bool
    {
        return $this->customerSessionService->checkIfExists();
    }

    public function getCustomerInfo(): ?CustomerDTO
    {
        $customerObject = $this->customerSessionService->getCurrentSession(false);
        return !empty($customerObject) ? CustomerDTO::fromObject($customerObject) : null;
    }

    /**
     * @throws ResourceNotFoundException
     * @throws LogicException
     * @throws CorePortalException
     */
    public function getCustomerByContractNo($contractNo, array $optionalData = []): ?CustomerDTO
    {
        $customer = $this->customerRepository->getCustomerByContractNo($contractNo, $optionalData);

        $this->throwIfNotFoundResource($customer, __("messages.contract_no.invalid"));

        return $customer;
    }

    private function processQRToken($token, $merchantCode) {
        $tripleDESKey = config("client.". $merchantCode. "key_triple_des");
        return $tripleDESKey ? $this->decryptTripleDES(urldecode($token), $tripleDESKey) : $token;
    }
}
