<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Controllers\Api\ApiController;
use App\Models\Common\Hash;
use App\Repositories\Common\HashRepository;

class HashController extends ApiController
{
    public function __construct(
        protected HashRepository $repo
    )
    {
        parent::__construct();
    }

    /**
     * @OA\Get (
     *     path="/api/v1/hash/{key}",
     *     tags={"Common"},
     *     summary="Получить хеш по ключу",
     *     description="Получить хеш по ключу",
     *
     *     @OA\Parameter(name="{key}", in="path", required=true,
     *          description="Ключ хеша",
     *          @OA\Schema(type="string", example="translation.app",
     *              enum={"translation.app"},
     *          )
     *     ),
     *
     *     @OA\Response(response="200", description="Хеш",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="string", description="Хеш", example="d2f757b4db9c3a4eb589dfab0ccbc5e70"),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function getHash($key)
    {
        try {
            /** @var $model Hash */
            $model = $this->repo->getBy('key', $key, true);

            return self::successJsonMessage($model->hash);
        } catch (\Throwable $e){
            return self::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/hash/{key}/{hash}",
     *     tags={"Common"},
     *     summary="Проверить хеш по ключа",
     *     description="Проверить хеш по ключа",
     *
     *     @OA\Parameter(name="{key}", in="path", required=true,
     *          description="Ключ хеша",
     *          @OA\Schema(type="string", example="translation.app",
     *              enum={"translation.app"},
     *          )
     *     ),
     *     @OA\Parameter(name="{hash}", in="path", required=true,
     *          description="Хеш",
     *          @OA\Schema(type="string", example="9b9c99f2a2a72e89c577f4b4cf17f9f3"
     *          )
     *     ),
     *
     *     @OA\Response(response="200", description="Хеш",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="boolean", description="Хеш совпал или нет", example=true),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function checkHash($key, $hash)
    {
        try {
            /** @var $model Hash */
            $model = $this->repo->getBy('key', $key, true);

            return self::successJsonMessage($model->hash === $hash);
        } catch (\Throwable $e){
            return self::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }
}


