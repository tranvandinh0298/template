<?php

namespace App\Services\PaymentMethod;

use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\DTOs\PaymentMethodDTO;
use App\Services\Customer\CustomerService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class PaymentMethodService
{
    use ResponseTrait;

    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getPaymentMethodsSession()
    {
        $customerSession = $this->customerService->getCustomerInfo();
        return $customerSession->merchantDTO->paymentMethodDTOs ?? null;
    }

    public function getPaymentMethodById($paymentMethodId): ?PaymentMethodDTO
    {
        return collect($this->getPaymentMethodsSession())->filter(function ($paymentMethod) use ($paymentMethodId) {
            return $paymentMethod->id == $paymentMethodId;
        })->first();
    }

    public function calculateFee($paymentMethodId, $amount): array
    {
        $paymentMethod = $this->getPaymentMethodById($paymentMethodId);

        $paymentFee = $paymentMethod->fix + ($paymentMethod->rate * $amount / 100);

        return [
            'amount' => $amount,
            'originAmount' => $amount,
            'fixedFee' => $paymentMethod->fix,
            'ratedFee' => $paymentMethod->rate,
            'paymentFee' => $paymentFee ?? 0,
            'totalAmount' => $amount + $paymentFee,
            'payType' => $paymentMethod->mgpCode,
            'bankCode' => $paymentMethod->mgpBankCode
        ];
    }

    public function checkIfSelectedPaymentMethodValid($selectedPaymentMethodId): bool
    {
        $allPaymentMethodIds = collect($this->getPaymentMethodsSession())->pluck("id");

        return $allPaymentMethodIds->search($selectedPaymentMethodId) !== FALSE;
    }
}
