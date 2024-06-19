<?php

namespace App\Traits;

use App\Exceptions\CorePortalException;
use App\Exceptions\LogicException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait RequestCoreTrait
{
    protected $endpoint;
    protected $headers = [];
    protected $requestData = [];

    public function generateRequestId(): string {
        return (string) Str::uuid();
    }

    public function setRequestData($requestData) {
        $this->requestData = $requestData;
    }

    public function getRequestData() {
        return $this->requestData;
    }

    /**
     * @throws CorePortalException
     */
    protected function handleInvalidResponse(Response $response) {
        $jsonToArray = $response->json();

        if ($response->failed()) {
            $this->throwCorePortalException(__("messages.core_portal.timeout"));
        }

        if (empty($jsonToArray['returnCode'])) {
            $this->throwCorePortalException(__("messages.core_portal.missing_return_code"));
        }
    }

    protected function isResponseSuccess($returnCode): bool
    {
        return $returnCode == CORE_SUCCESS_CODE;
    }

    /**
     * @throws CorePortalException
     */
    protected function throwCorePortalException($message) {
        throw new CorePortalException($message);
    }

    /**
     * @throws LogicException
     */
    protected function getPartnerKeyHash($partnerCode): string {
        if (empty(config("client.partners.".$partnerCode))) {
            throw new LogicException(__("messages.partner.missing_key_hash"));
        }
        return config("client.partners.".$partnerCode. ".key_hash");
    }
}
