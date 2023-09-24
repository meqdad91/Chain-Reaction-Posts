<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait APIResponseTrait
{
    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($response = null, $statusCode = Response::HTTP_OK)
    {
        if ($response instanceof \App\Http\Resources\APIPaginateCollection) {
            return response()->json([
                'success' => true,
                'code' => $statusCode,
                'data' => $response
            ], $statusCode);
        }
        if ($response) {
            return response()->json(
                [
                    'success' => true,
                    'code' => $statusCode,
                    'data' => $response
                ], $statusCode
            );
        }
        return response()->json(['data' => [
            'success' => true,
            'code' => $statusCode,
        ]], $statusCode);
    }

    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($exception, $statusCode = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            [
                'success' => false,
                'code' => $statusCode,
                'message' => $exception
            ]
        ], $statusCode);
    }
}
