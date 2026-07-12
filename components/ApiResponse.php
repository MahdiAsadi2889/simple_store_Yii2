<?php

namespace app\components;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Success'): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    public static function error(string $message = 'Error', mixed $errors = null): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ];
    }
}
