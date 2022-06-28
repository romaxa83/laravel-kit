<?php

namespace App\Http\Controllers\Api\V1\Localization;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\V1\Localization\LanguageResource;
use App\Repositories\Localization\LanguageRepository;
use App\Services\Localization\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends ApiController
{
    protected $orderBySupport = ['id', 'active', 'locale'];
    protected $defaultOrderBy = 'active';

    public function __construct(
        protected LanguageRepository $repo,
        protected LanguageService $service,
    )
    {
        parent::__construct();
    }

    /**
     * @OA\Get (
     *     path="/api/v1/languages",
     *     tags={"Localization"},
     *     summary="Список языков",
     *     security={{"Basic": {}}},
     *
     *     @OA\Parameter(name="id", in="query", required=false,
     *          description="Фильтр по id, можно передовать несколько значений, так - ?id[]=1&id[]=4",
     *          @OA\Schema(type="string", example="1")
     *     ),
     *     @OA\Parameter(name="name", in="query", required=false,
     *          description="Фильтр по названию языка",
     *          @OA\Schema(type="string", example="English")
     *     ),
     *     @OA\Parameter(name="slug", in="query", required=false,
     *          description="Фильтр по слагу языка, можно передовать несколько значений, так - ?slug[]=en&slug[]=uk",
     *          @OA\Schema(type="string", example="en")
     *     ),
     *     @OA\Parameter(name="locale", in="query", required=false,
     *          description="Фильтр по локали языка, можно передовать несколько значений, так - ?slug[]=en_EN&slug[]=uk_UA",
     *          @OA\Schema(type="string", example="en_EN")
     *     ),
     *     @OA\Parameter(name="active", in="query", required=false,
     *          description="Фильтр по активированым/деактивированым локалям",
     *          @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Parameter(name="default", in="query", required=false,
     *          description="Фильтр по дефолтному языку для приложения",
     *          @OA\Schema(type="boolean", example=true)
     *     ),
     *
     *     @OA\Parameter(name="order_by", in="query", required=false,
     *          description="Поле, по которому происходит сортировка",
     *          @OA\Schema(type="string", example="id", default="created_at", enum={"id", "active", "locale"})
     *     ),
     *     @OA\Parameter(name="order_type", in="query", required=false,
     *          description="Тип сортировки",
     *          @OA\Schema(type="string", example="asc", default="desc", enum={"asc", "desc"})
     *     ),
     *
     *     @OA\Response(response="200", description="Список локализаций",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", title="Data", type="array",
     *                  @OA\Items(ref="#/components/schemas/LanguageResource")
     *              ),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function list(Request $request): JsonResponse
    {
        try {
            $models = $this->repo->all(
                [],
                $request->all(),
                $this->orderDataForQuery()
            );

            return static::successJsonMessage(
                LanguageResource::collection($models));
        } catch (\Throwable $e){
            return static::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/languages/{id}",
     *     tags = {"Localization"},
     *     summary="Получение языка",
     *     security={{"Basic": {}}},
     *
     *     @OA\Parameter(name="{id}", in="path", required=true,
     *          description="ID зыка",
     *          @OA\Schema(type="integer", example=2)
     *     ),
     *
     *     @OA\Response(response="200", description="Запрашиваемая локаль",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", title="Data", type="object",
     *                   ref="#/components/schemas/LanguageResource"
     *              ),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function one($id): JsonResponse
    {
        try {
            return static::successJsonMessage(
                LanguageResource::make(
                    $this->repo->getBy('id', $id, true)
                )
        );
        } catch (\Throwable $e){
            return static::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }
}

