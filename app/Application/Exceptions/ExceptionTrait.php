<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OutOfBoundsException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

use function response;
use function sprintf;
use function str_replace;

trait ExceptionTrait
{
    public function apiExceptions(Request $request, Throwable $exception): HttpResponse
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->modelResponse($exception);
        }

        if ($this->isHttp($exception)) {
            return $this->httpResponse();
        }

        if ($this->isBound($exception)) {
            return $this->boundResponse();
        }

        if ($this->isMethodAllowed($exception)) {
            return $this->methodAllowedResponse();
        }

        return parent::render($request, $exception);
    }

    protected function modelResponse(ModelNotFoundException $exception): JsonResponse
    {
        $response = str_replace([
            'App\\Models\\',
            'App\\Domain\\Users\\Models\\'
        ], '', $exception->getModel());

        return response()->json([
            'error' => sprintf('%s not found', $response),
        ], Response::HTTP_NOT_FOUND);
    }

    protected function isHttp(Throwable $exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    protected function httpResponse(): JsonResponse
    {
        return response()->json([
            'error' => 'Url Not Found',
        ], Response::HTTP_NOT_FOUND);
    }

    protected function isBound(Throwable $exception): bool
    {
        return $exception instanceof OutOfBoundsException;
    }

    protected function boundResponse(): JsonResponse
    {
        return response()->json([
            'error' => 'Undefined Index',
        ], Response::HTTP_NOT_FOUND);
    }

    protected function isMethodAllowed(Throwable $exception): bool
    {
        return $exception instanceof MethodNotAllowedException;
    }

    protected function methodAllowedResponse(): JsonResponse
    {
        return response()->json([
            'error' => 'Method Not Supported',
        ], Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
