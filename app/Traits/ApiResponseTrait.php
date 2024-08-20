<?php

namespace App\Traits;

trait ApiResponseTrait
{
    //
    private function formatResponse($data, $message, $code)
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $code);
    }

    public function successResponse($data = [])
    {
        return $this->formatResponse($data, 'Success', 200);
    }

    public function createdResponse($data = [], $message = 'Resource created successfully')
    {
        return $this->formatResponse($data, $message, 201);
    }

    public function badRequestResponse($message = 'Bad request', $data = [])
    {
        return $this->formatResponse($data, $message, 400);
    }

    public function unauthorizedResponse($message = 'Unauthorized', $data = [])
    {
        return $this->formatResponse($data, $message, 401);
    }

    public function notFoundResponse($message = 'Resource not found', $data = [])
    {
        return $this->formatResponse($data, $message, 404);
    }

    public function methodNotAllowedResponse($message = 'Method not allowed', $data = [])
    {
        return $this->formatResponse($data, $message, 405);
    }

    public function validationFailedResponse($message = 'Validation failed', $data = [])
    {
        return $this->formatResponse($data, $message, 422);
    }

    public function internalErrorResponse($message = 'Internal server error', $data = [])
    {
        return $this->formatResponse($data, $message, 500);
    }
}
