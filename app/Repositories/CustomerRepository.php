<?php

namespace App\Repositories;

use App\Exceptions\CorePortalException;
use App\Exceptions\LogicException;
use App\Repositories\DTOs\CustomerDTO;
use App\Repositories\DTOs\MerchantDTO;
use App\Repositories\Interfaces\CustomerInterface;
use App\Repositories\Mappers\BillMapper;
use App\Repositories\Mappers\CustomerMapper;
use App\Repositories\Mappers\MerchantMapper;
use App\Repositories\Mappers\PaymentMethodMapper;
use App\Traits\RequestCoreTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Http;

class CustomerRepository implements CustomerInterface
{
    use RequestCoreTrait;
    use ResponseTrait;

    public function __construct()
    {
        $this->endpoint = config("client.core.check_bill_url");
    }

    /**
     * @throws LogicException
     * @throws CorePortalException
     */
    public function getCustomerByContractNo($contractNo, array $additionalData = []): ?CustomerDTO
    {
        $additionalData['contractNo'] = $contractNo;
        $this->setSearchingBillRequest($additionalData);

        $this->logInfo(__METHOD__ . " - REQUEST : " . json_encode(
                [
                    'endpoint' => $this->endpoint,
                    'method' => 'GET',
                    'requestData' => $this->requestData,
                ],
                256
            ));

//        $response = Http::post($this->endpoint, $this->getRequestData());
//
//        $this->logInfo(__METHOD__ . " - RESPONSE JSON: " . json_encode($response->json(), 256));
//
//        $this->handleInvalidResponse($response);
//        $responseData = $response->json();
        $responseData = [
            "returnCode" => 200,
            "returnMessage" => "",
            "data" => [
                "customerInfo" => [
                    "idNo" => "123456",
                    "customerName" => "Nguyễn Văn A",
                    "customerAddress" => "Tiểu học 12A"
                ],
                "billInfo" => [
                    "billId" => "2104fkaoowtja35",
                    "contractNo" => "DEMO000001",
                    "cycleCount" => 6,
                    "packOfCycle" => [
                        [
                            "CycleId" => "10001",
                            "CycleDate" => "01/2024",
                            "PaymentAmount" => 10000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 1",
                                    "ItemAmount" => 5000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 1",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                        [
                            "CycleId" => "10002",
                            "CycleDate" => "02/2024",
                            "PaymentAmount" => 11000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 2",
                                    "ItemAmount" => 6000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 2",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                        [
                            "CycleId" => "10003",
                            "CycleDate" => "03/2024",
                            "PaymentAmount" => 12000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 3",
                                    "ItemAmount" => 7000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 3",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                        [
                            "CycleId" => "10004",
                            "CycleDate" => "04/2024",
                            "PaymentAmount" => 13000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 4",
                                    "ItemAmount" => 8000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 4",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                        [
                            "CycleId" => "10005",
                            "CycleDate" => "05/2024",
                            "PaymentAmount" => 14000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 5",
                                    "ItemAmount" => 9000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 5",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                        [
                            "CycleId" => "10006",
                            "CycleDate" => "06/2024",
                            "PaymentAmount" => 15000,
                            "Status" => 0,
                            "PayDate" => 0,
                            "Detail" => [
                                [
                                    "ItemName" => "Học phí tháng 6",
                                    "ItemAmount" => 10000
                                ],
                                [
                                    "ItemName" => "Ăn trưa tháng 6",
                                    "ItemAmount" => 5000,
                                ]
                            ]
                        ],
                    ],
                ],
                "merchantInfo" => [
                    'id' => 100023,
                    'sub_id' => 'UUVIET001',
                    'sub_code' => '',
                    'first_name' => 'MN',
                    'last_name' => 'Tiểu học test',
                    'full_name' => 'UUVIET',
                    'tax_number' => '0308298773',
                    'resaler_id' => NULL,
                    'address' => 'Việt Nam',
                    'contact' => '02837301045',
                    'email' => 'stevenuniverse03@gmail.com,abc@gmail.com',
                    'staff' => 'DinhTV',
                    'fee_type' => 1,
                    'fee_bearer' => 0,
                    'holiday_pay' => 0,
                    'requirement' => 0,
                    'payment_channel' => 0,
                    'logo' => 'public/images/sub_schools/logo_coway.png',
                    'create_time' => '2023-08-22 15:08:16',
                    'update_time' => '2023-08-24 09:13:58',
                    'bank' => '970444',
                    'owner' => 'NGUYEN VAN A',
                    'card_number' => '1023020330000',
                    'active' => 1,
                    'is_resaler' => 0,
                    'enable_is' => 0,
                    'va_option' => 'WRIM',
                    'auto_payment' => 0,
                    'daily_report' => 1,
                    'testing_only' => 1,
                    'partner_code' => 'UUVIET',
                    'key_hash' => 'dtsoft123',
                    'option_payment' => NULL,
                    'remember_token' => NULL,
                ],
                "paymentMethods" => [
                    [
                        'method_id' => 1,
                        'name' => 'Thẻ ATM',
                        'fix' => 3300,
                        'rate' => 0,
                    ],
                    [
                        'method_id' => 5,
                        'name' => 'Chuyển khoản',
                        'fix' => 3300,
                        'rate' => 0,
                    ],
                    [
                        'method_id' => 4,
                        'name' => 'Ví MoMo',
                        'fix' => 0,
                        'rate' => 1.60,
                    ],
                    [
                        'method_id' => 3,
                        'name' => 'Ví ZaloPay',
                        'fix' => 0,
                        'rate' => 1.50,
                    ],
                    [
                        'method_id' => 7,
                        'name' => 'Ví ShopeePay',
                        'fix' => 0,
                        'rate' => 1.50,
                    ],
                    [
                        'method_id' => 8,
                        'name' => 'Ví Viettel Money',
                        'fix' => 0,
                        'rate' => 1.50,
                    ],
                    [
                        'method_id' => 2,
                        'name' => 'Thẻ quốc tế phát hành trong nước',
                        'fix' => 2200,
                        'rate' => 1.50,
                    ],
                    [
                        'method_id' => 10,
                        'name' => 'Thẻ quốc tế phát hành nước ngoài',
                        'fix' => 2200,
                        'rate' => 2.75,
                    ],
                    [
                        'method_id' => 9,
                        'name' => 'Mã VNPAY-QR',
                        'fix' => 0,
                        'rate' => 1.50,
                    ],
                    [
                        'method_id' => 13,
                        'name' => 'Trả sau HomeCredit',
                        'fix' => 0,
                        'rate' => 1.5,
                    ],
                    [
                        'method_id' => 14,
                        'name' => 'Trả sau Kredivo',
                        'fix' => 0,
                        'rate' => 1.5,
                    ],
                ]
            ]
        ];

        if ($this->isResponseSuccess($responseData['returnCode']) && !empty($responseData['data'])) {
            return $this->handleSuccessResponse($responseData['data']);
        }

        return null;
    }

    private function handleSuccessResponse($responseData): CustomerDTO
    {
        $customerInfo = $responseData['customerInfo'];
        $billInfo = $responseData['billInfo'];
        $merchantInfo = $responseData['merchantInfo'];
        $paymentMethods = $responseData['paymentMethods'] ?? [];

        $merchantDTO = MerchantMapper::toDTO($merchantInfo, $paymentMethods);

        $billId = $billInfo['billId'] ?? null;
        $billDTOs = collect($billInfo['packOfCycle'])->map(function ($bill) use ($billId) {
            return BillMapper::toDTO($bill, $billId);
        })->toArray() ?? [];

        return CustomerMapper::toDTO(
            array_merge($customerInfo, $billInfo),
            $merchantDTO,
            $billDTOs
        );
    }

    /**
     * @throws LogicException
     */
    private function setSearchingBillRequest($data)
    {
        $requestId = $this->generateRequestId();

        $merchantId = strtoupper($data['merchantCode']);

        $contractNo = $data['contractNo'];

        $keyHash = $this->getPartnerKeyHash($merchantId);

        $signature = bcrypt($merchantId . $contractNo . $requestId . $requestId . $keyHash);

        $this->setRequestData([
            'requestId' => $requestId,
            'merchantId' => $merchantId,
            'contractNo' => $contractNo,
            'signature' => $signature
        ]);
    }
}
