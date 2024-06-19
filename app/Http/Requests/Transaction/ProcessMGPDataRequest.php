<?php

namespace App\Http\Requests\Transaction;

use App\Rules\ValidBill;
use App\Rules\ValidPaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class ProcessMGPDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'billIds' => ['bail','required', 'array', $this->getValidBillRule()],
            'methodId' => ['bail','required', 'numeric', $this->getValidPaymentMethodRule()]
        ];
    }

    /**
     * Custom message error
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'billIds.required' => __('messages.bill.required'),
            'billIds.array' => __('messages.bill.array_format'),
            'methodId.required' => __('messages.payment_method.required'),
            'methodId.numeric' => __("messages.payment_method.invalid")
        ];
    }

    /**
     * Get the ValidBill rule instance.
     *
     * @return ValidBill
     */
    protected function getValidBillRule(): ValidBill
    {
        return app(ValidBill::class);
    }

    /**
     * Get the ValidPaymentMethod rule instance.
     *
     * @return ValidPaymentMethod
     */
    protected function getValidPaymentMethodRule(): ValidPaymentMethod
    {
        return app(ValidPaymentMethod::class);
    }
}
