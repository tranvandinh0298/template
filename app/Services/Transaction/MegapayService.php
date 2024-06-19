<?php

namespace App\Services\Transaction;

use App\Exceptions\MegapayException;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MegapayService {
    use ResponseTrait;
    // cấu hình MID
    private $config;

    /**
     * @throws MegapayException
     */
    public function __construct()
    {
        // set MGP config
        $this->setMegapayConfig();
    }

    /**
     * Set cấu hình MID của MGP
     *
     * @author dinhtv
     * @since 25/11/2023
     */
    public function setMegapayConfig()
    {
        if (
            empty(config('megapay')) ||
            empty(config('megapay.mer_id')) ||
            empty(config('megapay.encode_key')) ||
            empty(config('megapay.encrypt_key')) ||
            empty(config('megapay.decrypt_key')) ||
            empty(config('megapay.domain')) ||
            empty(config('megapay.check_trans_url')) ||
            empty(config('megapay.register_dc_url'))
        ) {
            throw new MegapayException(__("messages.megapay.missing_config"));
        }

        $this->config = [
            'merId' => config('megapay.mer_id'),
            'encodeKey' => config('megapay.encode_key'),
            'cancelPassword' => config('megapay.cancel_password'),
            'encryptKey' => config('megapay.encrypt_key'),
            'decryptKey' => config('megapay.decrypt_key'),
            'domain' => config('megapay.domain'),
            'checkTransUrl' => config('megapay.check_trans_url'),
            'cancelTransUrl' => config('megapay.cancel_trans_url'),
            'registerDcUrl' => config('megapay.register_dc_url')
        ];
    }

    /**
     * @throws MegapayException
     */
    public function processMegapayData($data): array
    {
        $this->logInfo(__METHOD__. " - ". json_encode($data));
        // timestamp
        $timeStamp = date('YmdHis');

        // merTrxId
        $merTrxId = $data['contractNo'] . '_' . strtoupper($data['subId']) . '_' . $timeStamp . '_' . rand(100, 10000);

        // invoiceNo
        $invoiceNo = 'ORDER_' . $timeStamp . '_' . rand(100, 10000);

        // description
        $description = strtoupper($data['subId']);

        // goodsNm
        $goodsNm = $data['goodsNm'];

        // totalAmount
        $totalAmount = $data['totalAmount'];

        // merId
        $merId = $this->config['merId'];

        // domain
        $domain = $this->config['domain'];

        // merchantToken
        $plainTxtToken = $timeStamp . $merTrxId . $merId . $totalAmount . $this->config['encodeKey'];
        $merchantToken = hash('sha256', $plainTxtToken);

        // buyerPhone
        $buyerPhone = '090' . rand(1000000, 9999999);

        // buyerAddr
        $buyerAddr = !empty($data['customerAddress']) ? $data['customerAddress'] : Str::random(10);

        // buyerCity
        $aryPro = [
            'Ha Giang', 'Cao Bang', 'Bac Kan', 'Lang Son', 'Tuyen Quang', 'Thai Nguyen',
            'Phu Tho', 'Bac Giang', 'Quang Ninh', 'Bac Ninh', 'Ha Noi', 'TP HCM', 'Ha Nam', 'Ha Tinh',
            'Hai Duong', 'Hau Giang', 'Hoa Binh', 'Hung Yen', 'Khanh Hoa', 'Kien Giang'
        ];
        $buyerCity = Arr::random($aryPro);

        // receiverFirstNm
        $aryFirstName = array('Dinh', 'Huyen', 'Nga', 'Manh', 'Minh', 'Hang', 'Luan', 'Quang', 'Hoa', 'Ha', 'Binh');
        $receiverFirstNm = Arr::random($aryFirstName);

        //receiverLastNm
        $aryLastName = array('Tran', 'Nguyen', 'Luu', 'Loi', 'Le');
        $receiverLastNm = Arr::random($aryLastName);

        //receiverPhone
        $receiverPhone = '090' . rand(1000000, 9999999);

        //receiverAddr
        $receiverAddr = Str::random(10);

        //receiverCity
        $receiverCity = Arr::random($aryPro);

        //buyerLastNm
        $buyerLastNm = $data['merchantLastName'] ?? $data['customerName'];
        $buyerLastNm = Str::of($buyerLastNm)->ascii()->upper();

        // buyerFirstNm
        $buyerFirstNm = $data['merchantFirstName'] ?? $data['customerName'];
        $buyerFirstNm = Str::of($buyerFirstNm)->ascii()->upper();

        // buyerEmail
        $buyerEmail =  Str::random(10) . '@gmail.com';

        // receiverEmail
        $receiverEmail =  Str::random(10) . '@gmail.com';

        // vaContent
        $vaContent = $data['contractNo'] . " ".$data['customerAddress'];
        $vaContent = Str::of($vaContent)->ascii()->limit(50)->upper();

        $megapayData = [
            // dữ liệu cho megapayForm
            'description' => $description,
            'amount' => $totalAmount,
            'merchantToken' => $merchantToken,
            'timeStamp' => $timeStamp,
            'merId' => $merId,
            'invoiceNo' => $invoiceNo,
            'merTrxId' => $merTrxId,
            'goodsNm' => $goodsNm,
            'buyerAddr' => $buyerAddr,
            'buyerLastNm' => $buyerLastNm,
            'buyerFirstNm' => $buyerFirstNm,
            'buyerEmail' => $buyerEmail,
            'buyerPhone' => $buyerPhone,
            'receiverAddr' => $receiverAddr,
            'receiverLastNm' => $receiverLastNm,
            'receiverFirstNm' => $receiverFirstNm,
            'receiverEmail' => $receiverEmail,
            'receiverPhone' => $receiverPhone,
            'termIs' => '',
            'domain' => $domain,
            'payToken' =>  '',
            'windowColor' => config("megapay.window_color"),
            'payType' => $data['payType'],
            'bankCode' => $data['bankCode'],
            'vaContent' => $vaContent
        ];

        if ($data['methodId'] == PAYMENT_METHOD_DEPOSIT_CODE_ID) {
            $megapayData['bankCode'] = $data['vaOption'] ?? null;
            return $this->registerDepositCode($megapayData);
        }

        return $megapayData;
    }

    /**
     * Hàm mapping deposit code trên MGP
     *
     * @throws MegapayException
     * @since 28/11/2023
     * @author dinhtv
     */
    public function registerDepositCode($data): array
    {
        $registerDcUrl = $this->config['registerDcUrl'];

        // requestData
        $requestData = [
            "merId" => $data["merId"],
            "currency" => "VND",
            "amount" => $data["amount"],
            "invoiceNo" => $data["invoiceNo"],
            "goodsNm" => $data["goodsNm"],
            "buyerFirstNm" => $data["buyerFirstNm"],
            "buyerLastNm" => $data["buyerLastNm"],
            "buyerPhone" => $data["buyerPhone"],
            "buyerEmail" => $data["buyerEmail"],
            "notiUrl" => secure_url(route("transaction.notify")),
            "description" => $data["description"],
            "merchantToken" => $data["merchantToken"],
            "reqServerIP" => "",
            "reqClientVer" => "",
            "userIP" => "123",
            "userLanguage" => "VN",
            "timeStamp" => $data["timeStamp"],
            "merTrxId" => $data["merTrxId"],
            "vaStartDt" => date("YmdHis", time()),
            "vaEndDt" => date("Ymd235959", strtotime(" +3 days")),
            "bankCode" => $data["bankCode"],
            "vaContent" => $data['vaContent']
        ];

        $this->logInfo(__METHOD__ . ' - REQUEST: ' . json_encode([
                'url' => $registerDcUrl,
                'requestData' => $requestData
            ], 256));

//        $response = Http::acceptJson()->asForm()->post($registerDcUrl, $requestData);
//        $result = $response->json();

        $result = '{"trxId":"EPAY000001VA202406150945288156","merId":"EPAY000001","merTrxId":"DEMO000001_UUVIET001_20240615094622_1085","resultCd":"00_005","resultMsg":"SUCCESS","invoiceNo":"ORDER_20240615094622_5504","amount":"24300","currency":"VND","goodsNm":"01\/2024,02\/2024","payType":"VA","merchantToken":"4cb824d2a6b6e7d43e3bb4608338507b483e2241a535e508ec5d5e20eeb2a258","transDt":"20240615","transTm":"094528","timeStamp":"1718419584242","vaNumber":"902000228613","vaName":"VAP001 EPAY000001","startDt":"20240615094622","endDt":"20240618235959","userFee":"0","bankId":"WRIM","bankName":"WOORIBANK","condition":"03","qrCode":"iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQAAAADjreInAAADlklEQVR42u2dXW7cMAyEBfD+d+0BCLD1WhyOZCdo0YdC7Oxik4WjT0+E+DdURvzV68cQL168ePHixYsX\/+e8j8\/Lri\/m+P35XM\/91zuu5+FGq8V34e3+6ZOei6+l9zZWGxtWi+\/D36uuL9Nmpn18VjlvYrVafDc+5g65LG2JnriJb8vXsXGDaUq375hnh\/h+fO0SkYs\/UUMZVMUP3\/gf8Ufyo+LE33h\/GX+KP5PPF+LHXJTWhD99n3+KP5f3aRI+s0aKI9NdZDYxcIiIb8RndBCTt0wpjUyr6gni2\/Dz0Jg54sgYcUaOnsFDZpOJiG\/CV4oYWUS400YLpI0jswv+Kb4JfzuJ24mkvczPPD4QTxhcjfgm\/PQGc4uZNEbCnlEE7Sy+E0\/Fg+BzI5ySBq\/2ke3nh\/izeSSJFUhwOykjC+OTRnwfnnuF92Ex20SoGw\/apNIH8T14R\/fAFyVBygiWJlI8\/Yf4s\/nCsE+1DlE18qWmZOK78L7UByujyG3IvwxWF4jvwVPyMFA\/QFZRwoKKMCzE9+GzOTzGWjMyqi1SLEE7iO\/AR5BcxLZYMSJINhSzmyS+Ee9pNegYkKYkg0a2L9\/rT+JP5hcNCfrIFCukMfET8W348g6VItYX6hhWRdlCfCeedMEcS6SjIPkAnyjiW\/DxsBWoyBE7ZnIJTamJ78LXVFgJiWt6DAvIgTz7j+LP5SEToGEC6Me3nVg9Ir4JnyGEo380qG0wxqNv9Ow\/iz+XR4l4cSKlJdtai27iu\/EcNmaAsMKbwmDzP+JP5vfWYc6QvYmHabZEfBc+cW4g8j7DeMj0WT8SfzLP02HoFVH7kELKdXxYfA+eLahqRygmZYmJQwg38X347BNiWpDLRFUuhnj4MT8s\/mS+poMqQhxUPfLqIQV0xOK78PulUTRHwtUlr\/Dhbf5Q\/LG8sQ9ZUkcaLsdk8RfzR+JP5euuKFKKpIoACuLnPUPie\/B1Z8SeKJiTXnzxH7t+XPy5fHWFUDCsMTG0EIyevMQf4s\/lST+61Y2XWkI8Gsjim\/DcFIy6Q46TB4vt8BDfhKf74+j2AOoe0rURJC0S34Un0RjGh8dg\/QiaSDRZJL4NjwuiSSdEMjLOHHG5mPhuPNsQJQx1eZRv8kHxvXjH\/4oYdFVQORDjSXPxfXhWES8TonSlDAtI4zV+EH8ov86J0S0haCvyIMlL\/VD8yfy\/\/v9T4sWLFy9evHjx\/xH\/EwiVNKt1G7gnAAAAAElFTkSuQmCC"}';
        $result = json_decode($result, true);

        $this->logInfo(__METHOD__ . ' - RESPONSE: ' . json_encode($result, 256));

//        if ($response->failed()) {
//            throw new MegapayException(__("messages.megapay.timeout"));
//        }

        if (empty($result)) {
            throw new MegapayException(__('messages.megapay.empty_data'));
        }

        if (empty($result['vaContent'])) {
            $result['vaContent'] = $data['vaContent'];
        }

        return $this->handleResult($result);
    }

    /**
     * @throws MegapayException
     */
    public function handleResult(array $data): array
    {
        $this->logInfo(__METHOD__ . ' handle transaction result');

        $checkToken = $this->checkToken($data);

        if (!$checkToken) {
            $data = $this->checkTrans($data['merTrxId']);
        }

        if (empty($data)) {
            throw new MegapayException(__('messages.empty_data'));
        }

        $resultCd = trim($data['resultCd']) ?? "";
        $resultMessage = trim($data['resultMsg']) ?? "";

        $result = [
            'mgpMsg' => $resultMessage,
            'mgpResponseCode' => $resultCd,
        ];

        $result['status'] = $result['mgpStatus'] = $this->convertResultToTransactionStatus($resultCd, $data);
        $result['mgpSuccessTime'] = $this->isResultSuccess($resultCd) ? date("Y-m-d H:i:s") : '';

        // web portal transaction id
        $result['merTrxId'] = $data['merTrxId'];
        if (!empty($data['trxId'])) {
            $result['mgpId'] = $data['trxId'];
        }
        if (!empty($data['vaNumber'])) {
            $result['vaNumber'] = $data['vaNumber'];
        }
        if (!empty($data['vaName'])) {
            $result['vaName'] = $data['vaName'];
        }
        if (!empty($data['startDt'])) {
            $result['vaStartDate'] = $data['startDt'];
        }
        if (!empty($data['endDt'])) {
            $result['vaEndDate'] = $data['endDt'];
        }
        if (!empty($data['qrCode'])) {
            $result['vaQrCode'] = $data['qrCode'];
        }
        if (!empty($data['bankId'])) {
            $result['bankCode'] = $data['bankId'];
        }
        if (!empty($data['bankName'])) {
            $result['bankName'] = $data['bankName'];
        }
        if (!empty($data['vaContent'])) {
            $result['vaContent'] = $data['vaContent'];
        }

        $this->logInfo("resultData:" . json_encode($result));

        return $result;
    }

    /**
     * @throws MegapayException
     */
    protected function checkTrans($merTrxId)
    {
        // timestamp
        $timeStamp = date('YmdHis');

        // merId
        $merId = $this->config['merId'];

        // merchantToken
        $plainTxtToken = $timeStamp . $merTrxId . $merId . $this->config['encodeKey'];
        $merchantToken = hash('sha256', $plainTxtToken);

        // checktransUrl
        $checkTransUrl = $this->config['checkTransUrl'];

        $requestData = [
            'merId' => $merId,
            'merTrxId' => $merTrxId,
            'merchantToken' => $merchantToken,
            'timeStamp' => $timeStamp,
        ];

        $this->logInfo(__METHOD__ . ' - REQUEST: ' . json_encode([
                'url' => $checkTransUrl,
                'requestData' => $requestData
            ], 256));

        $response = Http::acceptJson()->asForm()->post($checkTransUrl, $requestData);

        $result = $response->json();

        $this->logInfo(__METHOD__ . ' - RESPONSE: ' . json_encode($result, 256));

        if ($response->failed()) {
            throw new MegapayException(__("messages.megapay.timeout"));
        }

        return !empty($result['data']) ? $result['data'] : null;
    }

    protected function checkToken($data): bool
    {
        // resultCd
        $resultCd = $data['resultCd'] ?? '';

        // timeStamp
        $timeStamp = $data['timeStamp'] ?? '';

        // merTrxId
        $merTrxId = $data['merTrxId'] ?? '';

        // trxId
        $trxId = $data['trxId'] ?? '';

        // amount
        $amount = $data['amount'] ?? '';

        // userFee
        $userFee = $data['userFee'] ?? '';

        // merchantToken
        $merchantToken = $data['merchantToken'] ?? '';

        // xác thực token của các hàm API
        $str = $resultCd . $timeStamp . $merTrxId . $trxId . $this->config['merId'] . $amount . $this->config['encodeKey'];

        if (!empty($userFee)) {
            $str = $resultCd . $timeStamp . $merTrxId . $trxId . $this->config['merId'] . $amount . $userFee .  $this->config['encodeKey'];
        }

        // token
        $token = hash('sha256', $str);

        $this->logInfo(__METHOD__. " check token result: ".($token == $merchantToken));

        return $token == $merchantToken;
    }

    protected function convertResultToTransactionStatus($resultCd, array $mgpData): int
    {
        if ($this->isResultPending($resultCd, $mgpData)) {
            // giao dịch đang được xử lý
            return TRANS_STATUS_PENDING;
        }

        if ($this->isResultSuccess($resultCd)) {
            // giao dịch thành công
            return TRANS_STATUS_SUCCESS;
        }

        if ($this->isResultWaiting($resultCd)) {
            // giao dịch deposit code, chờ thành toán
            return TRANS_STATUS_WAITING;
        }

        return TRANS_STATUS_FAILED;
    }

    protected function isResultPending($resultCd, array $data): bool
    {
        return empty($resultCd) ||
            ($resultCd == 'null') ||
            ($resultCd == '') ||
            ($resultCd == TRANS_MGP_STATUS_PENDING) ||
            ($resultCd != TRANS_MGP_STATUS_WAITING && !in_array($data['status'], TRANS_MGP_STATUS));
    }

    protected function isResultSuccess($resultCd): bool
    {
        return $resultCd == TRANS_MGP_STATUS_SUCCESS;
    }

    protected function isResultWaiting($resultCd): bool
    {
        return $resultCd == TRANS_MGP_STATUS_WAITING;
    }
}
