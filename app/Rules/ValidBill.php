<?php

namespace App\Rules;

use App\Exceptions\LogicException;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Bill\BillService;
use App\Services\Customer\CustomerService;
use Illuminate\Contracts\Validation\Rule;

class ValidBill implements Rule
{
    protected $billService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->billService->checkIfSelectedBillsValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __("messages.bill.invalid");
    }
}
