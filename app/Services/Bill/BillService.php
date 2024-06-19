<?php

namespace App\Services\Bill;

use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Customer\CustomerService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class BillService
{
    use ResponseTrait;

    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getBillsSession() {
        $customerSession = $this->customerService->getCustomerInfo();
        return $customerSession->billDTOs ?? null;
    }

    public function checkIfBillsSessionExist(): bool
    {
        return $this->getBillsSession() == null;
    }

    public function getBillByIds($billIds): array
    {
        $allBills = $this->getBillsSession();

        return collect($allBills)->filter(function ($bill) use ($billIds) {
            return in_array($bill->id, $billIds);
        })->toArray();
    }

    public function checkIfSelectedBillsValid($selectedBillIds): bool
    {
        $allBillIds = collect($this->getBillsSession())->pluck("id");

        return !empty($selectedBillIds) && collect($selectedBillIds)->every(function ($selectedBillId) use ($allBillIds) {
            return $allBillIds->search($selectedBillId) !== FALSE;
        });
    }

    public function updateBillStatus(array $selectedBillDTOIds, $status) {
        $this->logInfo("selectedBillDTOIds: ". json_encode($selectedBillDTOIds));

        $customerSession = $this->customerService->getCustomerInfo();
        if (empty($customerSession)) {
            return null;
        }

        $this->logInfo("CUSTOMER SESSION BEFORE: ". json_encode($customerSession));

        $allBillDTOs = $customerSession->billDTOs;
        foreach ($allBillDTOs as &$billDTO) {
            if (in_array($billDTO->id, $selectedBillDTOIds)) {
                $this->logInfo("update billDTO status: ".$billDTO->status. " - to status: ". $status);
                $billDTO->status = $status;
                $billDTO->paymentDate = date("Y-m-d H:i:s");
            }
        }

        $this->logInfo("CUSTOMER SESSION AFTER: ". json_encode($customerSession));

        return $this->customerService->updateCustomerSession($customerSession);
    }

    public function updateBillStatusSuccess(array $selectedBillDTOs) {
        return $this->updateBillStatus($selectedBillDTOs, COMPLETED_BILL_PAYMENT);
    }

    public function updateBillStatusFail(array $selectedBillDTOs) {
        return $this->updateBillStatus($selectedBillDTOs, ALLOW_BILL_PAYMENT);
    }
}
