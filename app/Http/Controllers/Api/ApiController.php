<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiOrderBy;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     title="API documentation",
 *     version="1.0.0",
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Get(
 *     path="/api/version",
 *     @OA\Response(response="200", description="An example resource")
 * )
 * @OA\Tag(
 *     name="Auth",
 *     description="Авторизация",
 * )
 * @OA\Tag(
 *     name="Localization",
 *     description="Локализация",
 * )
 * @OA\Server(
 *     description="stage server",
 *     url="http://jddemo.wezom.agency/api"
 * )
 * @OA\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     securityScheme="Basic"
 * )
 * @OA\Parameter(
 *     parameter="Content-Language",
 *     name="Content-Language",
 *     in="header",
 *     required=false,
 *     @OA\Schema(
 *        type="string",
 *        default="en"
 *     )
 * )
 */

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
