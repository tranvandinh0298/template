<?php

namespace App\Services\Customer;

use App\Repositories\CustomerRepository;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Log;

class CustomerSessionService {
    use SessionTrait;

    public function __construct() {
        $this->sessionLabel = config('client.customer_session');
        $this->keyLabel = 'contractNo';
    }
}

