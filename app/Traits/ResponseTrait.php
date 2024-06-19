<?php

namespace App\Traits;

use App\Exceptions\CustomResourceNotFoundException;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    private function successResponse($data, $code = 200):JsonResponse
    {
        $responseData = [
            'data' => $data,
            'code' => $code
        ];
        $this->endLog($responseData);
        return response()->json($responseData, $code);
    }

    protected function errorResponse($message, $code): JsonResponse
    {
        $responseData = [
            'message' => $message,
            'code' => $code
        ];
        $this->endLog($responseData);
        return response()->json($responseData, $code);
    }

    protected function redirectBackWithErrors($messages = [], $httpStatusCode = 500) {
        $this->endLog(['type' => "redirect back", 'data' => ['messages'=> $messages, 'httpStatusCode' => 500]]);
        return redirect()->back()->withErrors(['messages' => $messages])->setStatusCode($httpStatusCode);
    }

    protected function viewResponse($view, $data): Response
    {
        $this->endLog(['view' => $view, 'data' => $data]);
        return response()->view($view, $data);
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function () use ($data) {
            return $data;
        });
    }

    public function logLine()
    {
        Log::info("===========================================================");
    }

    public function prefixLog()
    {
        return request()->requestId ?? request()->merTrxId ?? request()->ip();
    }

    public function logInfo($message)
    {
        $message = is_string($message) ? $message : json_encode($message, 256);
        Log::info($this->prefixLog() . " - " . $message);
    }

    public function startLog($requestData)
    {
        $this->logLine();
        $this->logInfo("REQUEST: " . json_encode($requestData, 256));
    }

    public function endLog($responseData)
    {
        $this->logInfo("RESPONSE: " . json_encode($responseData, 256));
        $this->logLine();
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function throwIfNotFoundResource($resource, $message = '')
    {
        if (empty($resource))
            throw new ResourceNotFoundException($message);
    }

    public function redirectNotFoundResource($resource, $route = 'home.index', $message = '')
    {
        if (empty($resource)) {
            return redirect()->route($route)->with('flashErrorMessage', $message);
        }
    }
}
