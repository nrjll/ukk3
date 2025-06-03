<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * Success response
     */
    public function sendResponse($result, $message = 'Success', $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code);
    }

    /**
     * Error response
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}