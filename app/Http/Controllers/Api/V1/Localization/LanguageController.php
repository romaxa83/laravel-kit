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

