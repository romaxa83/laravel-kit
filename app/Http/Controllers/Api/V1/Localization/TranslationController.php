<?php

namespace App\Http\Controllers\Api\V1\Localization;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\V1\Localization\LanguageResource;
use App\Repositories\Localization\LanguageRepository;
use App\Services\Localization\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends ApiController
{
    public function __construct(
        protected LanguageRepository $repo,
        protected LanguageService $service,
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
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/SuccessMessageResponse")),
     *     @OA\Response(response="400", description="Error", @OA\JsonContent(ref="#/components/schemas/ErrorResponse")),
     * )
     */
    public function setTranslation(Request $request)
    {
        try {
//            $this->service->saveOrUpdate(
//                TranslationsDTO::byRequestFromApp($request->all())
//            );

//            // перезаписываем версии перевода
//            Version::setVersion(
//                Version::TRANSLATES,
//                Version::getHash($this->repo->getAllAsArray(Translate::TYPE_SITE))
//            );

            return $this->successJsonMessage(__('message.translate_set'));
        } catch (\Exception $exception){
            return $this->errorJsonMessage($exception->getMessage());
        }
    }
}


