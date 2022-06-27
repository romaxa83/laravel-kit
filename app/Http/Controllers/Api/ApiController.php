<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiOrderBy;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    use ApiOrderBy;

    public function __construct()
    {
        $this->checkAndFillOrderBy(request()->input('order_by') ?? $this->defaultOrderBy);
        $this->checkAndFillOrderByType(request()->input('order_type') ?? $this->defaultOrderByType);
    }

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
