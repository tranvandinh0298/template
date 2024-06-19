<?php

namespace App\Rules;

use App\Services\PaymentMethod\PaymentMethodService;
use Illuminate\Contracts\Validation\Rule;

class ValidPaymentMethod implements Rule
{
    protected $paymentMethodService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->paymentMethodService->checkIfSelectedPaymentMethodValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __("messages.payment_method.non_existent");
    }
}
