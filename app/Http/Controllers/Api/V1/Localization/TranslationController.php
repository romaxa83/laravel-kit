<?php

namespace App\Http\Controllers\Api\V1\Localization;

use App\DTO\Localization\TranslationDtos;
use App\Http\Controllers\Api\ApiController;
use App\Http\Request\Api\V1\Localization\Translation\SetTranslationRequest;
use App\Repositories\Localization\TranslationRepository;
use App\Services\Localization\TranslationService;

class TranslationController extends ApiController
{
    public function __construct(
        protected TranslationRepository $repo,
        protected TranslationService $service,
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
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/SuccessResponse")),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function setTranslation(SetTranslationRequest $request)
    {
        try {
            $this->service->saveOrUpdate(
                TranslationDtos::byRequestFromApp($request->all())
            );

            return self::successJsonMessage(__('message.translate_set'));
        } catch (\Exception $exception){
            return self::errorJsonMessage($exception->getMessage(), $exception->getCode());
        }
    }
}


