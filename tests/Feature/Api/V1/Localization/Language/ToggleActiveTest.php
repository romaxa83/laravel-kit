<?php

namespace Tests\Feature\Api\V1\Localization\Language;

use App\Models\Localization\Language;
use App\Services\Localization\LanguageService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class ToggleActiveTest extends TestCase
{
    use DatabaseTransactions;
    use ResponseStructure;

    protected $userBuilder;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function success_toggle_to_true(): void
    {
        /** @var $model Language */
        $model = Language::query()->where('active', true)->first();

        $this->assertTrue($model->isActive());

        $this->putJson(route('api.v1.languages.toggle-active', ['id' => $model->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "id" => $model->id,
                "active" => false,
            ]))
        ;

        $model->refresh();

        $this->assertFalse($model->isActive());
    }

    /** @test */
    public function success_toggle_to_false(): void
    {
        /** @var $model Language */
        $model = Language::query()->where('active', false)->first();

        $this->assertFalse($model->isActive());

        $this->putJson(route('api.v1.languages.toggle-active', ['id' => $model->id]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "id" => $model->id,
                "active" => true,
            ]))
        ;

        $model->refresh();

        $this->assertTrue($model->isActive());
    }

    /** @test */
    public function fail_not_model(): void
    {
        $this->putJson(route('api.v1.languages.toggle-active', ['id' => 10]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse(
                "Model [". Language::class ."] not found by [id = 10]"
            ))
        ;
    }

    /** @test */
    public function fail_repo_return_exception()
    {
        $this->mock(LanguageService::class, function(MockInterface $mock){
            $mock->shouldReceive("toggleActive")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_BAD_REQUEST);
        });

        $this->putJson(route('api.v1.languages.toggle-active', ['id' => 1]))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }
}
