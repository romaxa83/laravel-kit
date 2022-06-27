<?php

namespace Tests\Feature\Api\V1\Localization\Language;

use App\Models\Localization\Language;
use App\Repositories\Localization\LanguageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class OneTest extends TestCase
{
    use DatabaseTransactions;
    use ResponseStructure;

    protected $userBuilder;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function success(): void
    {
        /** @var $model Language */
        $model = Language::query()->where('id', 1)->first();

        $this->getJson(route('api.v1.languages.one', ['id' => 1]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "id" => $model->id,
                "name" => $model->name,
                "native" => $model->native,
                "slug" => $model->slug,
                "locale" => $model->locale,
                "active" => $model->active,
                "default" => $model->default,
            ]))
        ;
    }

    /** @test */
    public function fail_not_model(): void
    {
        $this->getJson(route('api.v1.languages.one', ['id' => 10]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse(
                "Model [". Language::class ."] not found by [id = 10]"
            ))
        ;
    }

    /** @test */
    public function fail_repo_return_exception()
    {
        $this->mock(LanguageRepository::class, function(MockInterface $mock){
            $mock->shouldReceive("getBy")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_BAD_REQUEST);
        });

        $this->getJson(route('api.v1.languages.one', ['id' => 1]))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }

}

