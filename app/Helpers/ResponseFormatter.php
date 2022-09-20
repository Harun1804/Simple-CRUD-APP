<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'status'    => true,
            'message'   => 'Berhasil',
            'code'      => 200
        ],
        'data' => []
    ];

    public static function success($data, $message)
    {
        self::$response['meta']['message']  = $message;
        self::$response['data']             = $data;

        return Response()->json(self::$response,self::$response['meta']['code']);
    }

    public static function error($data, $message = 'Validation Error', $code = 500)
    {
        self::$response['meta']['status']   = false;
        self::$response['meta']['message']  = $message;
        self::$response['meta']['code']     = $code;
        self::$response['data']             = $data;

        return Response()->json(self::$response,self::$response['meta']['code']);
    }
}

