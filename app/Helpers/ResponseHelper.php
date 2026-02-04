<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Success response format.
     */
    public static function success($data = null, string $message = 'Operación exitosa', int $code = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ];
    }

    /**
     * Error response format.
     */
    public static function error(string $message = 'Error en la operación', $errors = null, int $code = 400): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $code,
        ];
    }

    /**
     * Validation error response.
     */
    public static function validationError(array $errors, string $message = 'Error de validación'): array
    {
        return self::error($message, $errors, 422);
    }

    /**
     * Not found response.
     */
    public static function notFound(string $resource = 'Recurso'): array
    {
        return self::error("{$resource} no encontrado", null, 404);
    }

    /**
     * Unauthorized response.
     */
    public static function unauthorized(string $message = 'No autorizado'): array
    {
        return self::error($message, null, 401);
    }
}
