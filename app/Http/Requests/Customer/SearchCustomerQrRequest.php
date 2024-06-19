<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class SearchCustomerQrRequest extends FormRequest
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
            'token' => 'required'
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
            'contractNo.required' => __('messages.contract_no.qr_required'),
        ];
    }
}
