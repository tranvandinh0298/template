<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class SearchCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'contractNo' => 'required'
        ];
    }

    /**
     * Custom message error
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contractNo.required' => __('messages.contract_no.required'),
        ];
    }
}
