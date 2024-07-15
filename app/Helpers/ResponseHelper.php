<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = "Sukses", $code = 200)
    {
        return response()->json([
            'data' => [
                'code' => $code,
                'status' => true,
                'message' => $message,
                'results' => $data,
            ]
        ], $code);
    }

    public static function error($message, $code = 400)
    {
        return response()->json([
            'data' => [
                'code' => $code,
                'status' => false,
                'message' => $message,
                'results' => null,
            ]
        ], $code);
    }
}
