<?php

namespace App\Traits;

use App\Http\Requests\Bill\retrieveBillRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait SessionTrait
{
    // biến dùng làm tên session
    protected $sessionLabel;

    // biến dùng để đối chiếu xem session có cần phải làm mới không
    protected $keyLabel;

    // các biến cần truyền vào
    protected $data = [];

    /**
     * get tên gán cho session
     *
     * @example $_SESSION['partner']
     * @author dinhtv
     * @return string
     * @since 10/10/2023
     */
    protected function getLabel(): string
    {
        return $this->sessionLabel;
    }

    /**
     * get khóa định danh cho session
     *
     * @example $_SESSION['partner']['code']
     * @author dinhtv
     * @return string
     * @since 10/10/2023
     */
    protected function getKey(): string
    {
        return $this->keyLabel;
    }

    /**
     * set data
     *
     * @author dinhtv
     * @param array $data
     * @since 10/10/2023
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * set session nếu chưa tồn tại hoặc là cần làm mới session tương ứng với 1 đối tượng cụ thể
     *
     * @param array $data
     * @author dinhtv
     * @since 10/10/2023
     */
    public function setSession(array $data)
    {
        // check session
        if ($this->checkIfNewSessionIsNeeded($data)) {
            Log::info("need new session");

            // xóa bỏ session trước nếu có tồn tại
            $this->removePreviousSession();

            // set session mới
            $this->setNewSession($data);
        } else {
            Log::info("keep current session");
        }
    }

    /**
     * set session mới hoàn toàn
     *
     * @author dinhtv
     * @param mixed $data
     * @since 10/10/2023
     */
    public function setNewSession($data)
    {
        return request()->session()->put($this->getLabel(), json_encode($data));
    }

    /**
     * get current session
     *
     * @author dinhtv
     * @param string $code
     * @since 10/10/2023
     */
    public function getCurrentSession($returnAsArray = true)
    {
        return request()->session()->has($this->getLabel()) ? $this->returnSession($returnAsArray) : null;
    }

    public function returnSession($asArray = true) {
        return $asArray ? json_decode(session($this->getLabel()), true) : json_decode(session($this->getLabel()));
    }


    /**
     * get current key
     *
     * @author dinhtv
     * @return string|null
     * @since 12/10/2023
     */
    public function getCurrentKey(): ?string
    {
        $currentSession = $this->getCurrentSession();

        return !empty($currentSession[$this->getKey()]) ? $currentSession[$this->getKey()] : null;
    }

    /**
     * Kiểm tra xem session đã tồn tại hay chưa
     *
     * @author dinhtv
     * @since 12/10/2023
     */
    public function checkIfExists(): bool
    {
        return session()->has($this->getLabel());
    }

    /**
     * Chuyển hướng nếu session không tồn tại
     *
     * @author dinhtv
     * @param string $route
     * @since 19/10/2023
     */
    public function removePreviousSession()
    {
        if ($this->checkIfExists()) {
            session()->forget($this->getLabel());
        }
    }

    /**
     * Kiểm tra xem có cần tạo session mới dựa trên tham số key không
     *
     * @author dinhtv
     * @since 06/11/2023
     */
    public function checkIfNewSessionIsNeeded($data): bool
    {
        $incomingKey = $data[$this->getKey()] ?? null;

        $currentKey = $this->getCurrentKey();
//        Log::info("incomingKey: ". $incomingKey);
//        Log::info("currentKey: ".$currentKey);
//        Log::info('empty(currentKey): '.empty($currentKey));
//        Log::info('!empty($incomingKey) && $incomingKey == $currentKey: '. !empty($incomingKey) && $incomingKey == $currentKey);

        // check session
        return empty($currentKey) || !empty($incomingKey) && $incomingKey != $currentKey;
    }
}
