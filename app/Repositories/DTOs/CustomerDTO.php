<?php

namespace App\Repositories\DTOs;

use App\Models\Merchant;

class CustomerDTO
{
    public $id;
    public $contractNo;
    public $customerName;
    public $customerAddress;
    public $financialCode;
    public $merchantDTO = null;
    public $billDTOs = [];

    public function __construct($id, $contractNo, $customerName, $customerAddress, $financialCode, $merchantDTO = null, $billDTOs = [])
    {
        $this->id = $id;
        $this->contractNo = $contractNo;
        $this->customerName = $customerName;
        $this->customerAddress = $customerAddress;
        $this->financialCode = $financialCode;
        $this->merchantDTO = $merchantDTO;
        $this->billDTOs = $billDTOs;
    }

    public static function fromObject($customerObject): CustomerDTO
    {
        $billDTOs = collect($customerObject->billDTOs)->map(function($billObject) {
            return BillDTO::fromObject($billObject);
        })->toArray();

        $merchantDTO = MerchantDTO::fromObject($customerObject->merchantDTO);

        return new self(
            $customerObject->id,
            $customerObject->contractNo,
            $customerObject->customerName,
            $customerObject->customerAddress,
            $customerObject->financialCode,
            $merchantDTO,
            $billDTOs,
        );
    }
}
