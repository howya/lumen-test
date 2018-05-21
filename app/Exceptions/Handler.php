<?php

namespace App\Exceptions;

use App\ID3\Exceptions\InvalidFileException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $e)
    {
        $class = get_class($e);

        switch ($class) {

            case NotFoundHttpException::class:
                return $this->jsonResponse('Resource route not found', false, $e->getStatusCode());
                break;
            case MethodNotAllowedHttpException::class:
                return $this->jsonResponse('Not allowed in this context', false, $e->getStatusCode());
                break;
            case HttpException::class:
                return $this->jsonResponse($e->getMessage(), false, $e->getStatusCode());
                break;
            case ValidationException::class:
                return $this->jsonResponse('Unprocessable entity', $e->response->original, $e->getCode());
                break;
            case InvalidFileException::class:
                return $this->jsonResponse($e->getMessage(), false, $e->getStatusCode());
                break;
        }

        return parent::render($request, $e);
    }

    /**
     * @param $message
     * @param $detail
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function jsonResponse($message, $detail, $code)
    {
        $responseArray = [
            'message' => $message
        ];

        if ($detail) {
            $responseArray['detail'] = $detail;
        }

        return response()->json($responseArray, $code);
    }
}
