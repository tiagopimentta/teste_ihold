<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param \Exception|Throwable $e
     * @return Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Exception|Throwable $e): Response|JsonResponse|RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        return response()->json(
            $this->getJsonMessage($e),
            $this->getExceptionHTTPStatusCode($e)
        );
    }

    /**
     * @param $e
     * @return array
     */
    protected function getJsonMessage(\Exception|Throwable $e)
    {
        // You may add in the code, but it's duplication
        return [
            'status' => 'false',
            'message' => $e->getMessage()
        ];
    }

    protected function getExceptionHTTPStatusCode($e): int
    {
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ?
            $e->getStatusCode() : 500;
    }
}
