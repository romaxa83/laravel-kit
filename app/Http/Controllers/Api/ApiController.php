<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public static function successJsonMessage($message, $code = Response::HTTP_OK)
    {
        return response()->json([
            'data' => $message,
            'success' => true
        ], $code);
    }

    public static function errorJsonMessage($message, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            'data' => $message,
            'success' => false
        ], $code);
    }
}
