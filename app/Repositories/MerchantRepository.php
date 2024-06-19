<?php

namespace App\Repositories;

use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\CustomResourceNotFoundException;
use App\Models\Customer;
use App\Repositories\Interfaces\MerchantInterface;
use App\Repositories\Mappers\CustomerMapper;
use App\Traits\RequestCoreTrait;
use App\Traits\ResponseTrait;

class MerchantRepository implements MerchantInterface
{
    use RequestCoreTrait;
    public function __construct()
    {
    }

    public function getMerchantBySubIdAndPartnerCode($subId, $partnerCode)
    {
        $response = Http::post($this->getUrl(), $this->getData());

//        return $customer ? CustomerMapper::toDTO($customer) : null;
    }

    protected function setGetMerchantRequestData($data) {
        // requestId
        $requestId =  $this->generateRequestId();

        // partnerId
        $partnerCode = Str::of($data['partnerCode'])->upper();

        // keyHash
        $keyHash = config('client.merchants.' . $partnerCode);
        // Log::debug('keyHash: '. $keyHash);
        if (empty($keyHash)) {
            // Log::debug('empty keyHash');
            $this->throwUnknowPartnerException();
        }
        // Log::debug('not empty keyHash');

        // signature
        $signature = bcrypt($requestId . $partnerCode . $keyHash);

        // requestData
        $requestData = [
            'requestId' => $requestId,
            'merchantId' => $partnerCode,
            'signature' => $signature,
        ];

        // set data
        $this->setData($requestData);

        return $requestData;
    }

    /**
     * trích xuất dữ liệu
     * --------------------------------------------------
     * @author dinhtv
     * @param \Illuminate\Http\Client\Response
     * @throws \Exception
     * @return array|null
     * @since 12/10/2023
     */
    protected function extractData(Response $response = null): array
    {
        $extractData = [];
        $jsonToArray = $response->json();

        /**
         * các TH cần throw lỗi ko tìm thấy partner
         * * request client hoặc server xảy ra lỗi
         * * responseBody không chứa tham số returnCode
         * * responseBody chứa tham số returnCode không phải mã thành công
         */
        if ($response->failed() || empty($jsonToArray['returnCode']) || $jsonToArray['returnCode'] != CORE_SUCCESS_CODE) {
//            new
        }

        // extractData
        if (empty($jsonToArray['data'])) {
            $this->throwApiError($jsonToArray['message'] ?? '');
        } else {
            $data = $jsonToArray['data'];
        }

        // formatData
        $extractData = [
            'code' => strtolower($data["sub_id"]),
            'name' => $data["full_name"],
            'address' => $data["address"],
            'staff' => $data["staff"],
            'logo' => $data["logo"],
            'vaOption' => $data["va_option"] ?? '',
            'paymentMethods' => []
        ];

        return $extractData;
    }
}
