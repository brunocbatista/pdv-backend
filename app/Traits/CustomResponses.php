<?php

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait CustomResponses
{
    protected function makeMessage(string $message, array|null $data): array
    {
        return [
            'message' => $message,
            'data' => $data
        ];
    }

    public function sendJsonOK(array|null $data = null, string $message = 'Sucesso!', int $code = Response::HTTP_OK): JsonResponse
    {
        $response = $this->makeMessage($message, $data);
        return response()->json($response, $code);
    }

    public function sendJsonError(Throwable $exception): JsonResponse
    {
        $data = null;

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() != Response::HTTP_INTERNAL_SERVER_ERROR) {
            // abort exceptions
            $code = $exception->getStatusCode();
            $message = $exception->getMessage();
        } else if ($exception instanceof MissingAbilityException) {
            $code = Response::HTTP_FORBIDDEN;
            $message = "Você não tem permissão para acessar essa rota.";
        } else if ($exception instanceof ValidationException) {
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = 'Os dados fornecidos são inválidos. Por favor, tente novamente!';
            $data = $exception->errors();
        } else if ($exception instanceof AuthenticationException) {
            $code = Response::HTTP_UNAUTHORIZED;
            $message = 'Você não está autenticado.';
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Ocorreu um erro interno. Por favor, entre em contato com a equipe de suporte!';
            Log::error($exception);
        }

        $response = $this->makeMessage($message, $data);

        return response()->json($response, $code);
    }
}
