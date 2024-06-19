<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;
use Inertia\Inertia;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the exception into an HTTP response.
     * Target exception orrcured while handling a request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse | \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {

        Log::debug('======================================');
        Log::debug('Exception instance of ' . get_class($e));
        Log::debug('Message: ' . $e->getMessage());
        Log::debug('Code: ' . $e->getCode());
        Log::debug('======================================');

//        Validation exception
        if ($e instanceof ValidationException) {
            // lỗi validation
            $messages = collect($e->validator->getMessageBag()->getMessages())->collapse();
            Log::info("failed validation: ". json_encode($messages, 256));
            return redirect()->back()->withErrors(['messages' => $messages]);
        }

//        Megapay Exception
        if ($e instanceof MegapayException) {
            // lỗi cấu hình MGP
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        // Catch not found resource
        if ($e instanceof ResourceNotFoundException) {
            // không tìm thấy thông tin
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        // Catch custom exception
        if ($e instanceof LogicException) {
            // xảy ra lỗi logic trên server
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        $this->logInfo(['type' => "default handling exception", 'messages' => [__("messages.error.server_error")]]);
        return redirect()->back()->withErrors([__("messages.error.server_error")]);


//        Handle other exceptions
//        return parent::render($request, $e);
    }
}
