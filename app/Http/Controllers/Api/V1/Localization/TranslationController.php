<?php

namespace App\Http\Controllers\Api\V1\Localization;

use App\DTO\Localization\TranslationDtos;
use App\Http\Controllers\Api\ApiController;
use App\Http\Request\Api\V1\Localization\Translation\SetTranslationRequest;
use App\Http\Resources\Custom\CustomTranslationResource;
use App\Models\Common\Hash;
use App\Repositories\Localization\TranslationRepository;
use App\Services\Common\HashService;
use App\Services\Localization\TranslationService;
use Illuminate\Http\Request;

class TranslationController extends ApiController
{
    public function __construct(
        protected TranslationRepository $repo,
        protected TranslationService $service,
        protected HashService $hashService,
    )
    {
        parent::__construct();
    }

    /**
     * @OA\Post (
     *     path="/api/v1/translations",
     *     tags={"Localization"},
     *     summary="Установить переводы",
     *     description="Перевод будет создан, если такой перевод уже есть (по ключу и локали) то будет перезаписан",
     *
     *     @OA\RequestBody(required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SetTranslationRequest")
     *     ),
     *
     *     @OA\Response(response="200", description="Версия переводы",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="string", description="Хеш", example="d2f757b4db9c3a4eb589dfab0ccbc5e70"),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function setTranslation(SetTranslationRequest $request)
    {
        try {
            $this->service->saveOrUpdate(
                TranslationDtos::byRequestFromApp($request->all())
            );

            return self::successJsonMessage(
                $this->hashService->setHash(Hash::KEY_APP_TRANSLATION)
            );
        } catch (\Throwable $e){
            return self::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/translations",
     *     tags={"Localization"},
     *     summary="Получение переводов",
     *
     *     @OA\Parameter(name="key", in="query", required=false,
     *          description="Ключ перевода",
     *          @OA\Schema(type="string", example="button")
     *     ),
     *     @OA\Parameter(name="lang", in="query", required=false,
     *          description="Переводы по языку, можно передовать несколько значений, так - ?lang[]=en&lang[]=ua",
     *          @OA\Schema(type="string", example="ua",
     *              enum={"en", "ru", "ua"},
     *          )
     *     ),
     *
     *     @OA\Response(response="200", description="Переводы",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", title="Data", type="object",
     *                  ref="#/components/schemas/CustomTranslationResource"
     *              ),
     *              @OA\Property(property="success", title="Success", example=true),
     *         ),
     *     ),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function getTranslation(Request $request)
    {
        try {
            $models = $this->repo->getForApp($request->lang, $request->key);

            return self::successJsonMessage(
                (new CustomTranslationResource())->fill($models)
            );
        } catch (\Throwable $e){
            return self::errorJsonMessage($e->getMessage(), $e->getCode());
        }
    }
}


