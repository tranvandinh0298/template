<?php

namespace App\Repositories\Interfaces;

interface CustomerInterface {
    public function getCustomerByContractNo($contractNo, array $additionalData = []);
}
