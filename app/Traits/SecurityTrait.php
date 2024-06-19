<?php

namespace App\Traits;

use App\Exceptions\LogicException;
use Exception;

trait SecurityTrait
{
    /**
     * @throws LogicException
     */
    function encryptTripleDES($text, $key)
    {
        try {
            /**
             * Nếu key là 128 bits (16 ký tự) -> thì gán vào key 8 ký tự đầu để thành 192 bits (24 ký tự)
             */
            $key = md5(utf8_encode($key), true);
            if (strlen($key) == 16)
                $key .= substr($key, 0, 8);
            if (strlen($key) != 24)
                return false;
            $cipher = "DES-EDE3";
            $encData = openssl_encrypt($text, $cipher, $key, OPENSSL_RAW_DATA);
            return base64_encode($encData);
        } catch (Exception $e) {
            throw new LogicException("messages.contract_no.unable_to_encrypt_triple_des");
        }
    }

    /**
     * @throws LogicException
     */
    function decryptTripleDES($text, $key)
    {
        try {
            /**
             * Nếu key là 128 bits (16 ký tự) -> thì gán vào key 8 ký tự đầu để thành 192 bits (24 ký tự)
             */
            $key = md5(utf8_encode($key), true);
            if (strlen($key) == 16)
                $key .= substr($key, 0, 8);
            if (strlen($key) != 24)
                return false;
            $cipher = "DES-EDE3";
            $text = base64_decode($text);
            return openssl_decrypt($text, $cipher, $key, OPENSSL_RAW_DATA);
        } catch (Exception $e) {
            throw new LogicException("messages.contract_no.unable_to_decrypt_triple_des");
        }

    }
}
