<?php

namespace Tests\Feature\Api\V1\Common\Hash;

use App\Models\Common\Hash;
use App\Repositories\Common\HashRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\Feature\Api\V1\Localization\Translation\SetTranslationTest;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class CheckHashTest extends TestCase
{
    use DatabaseTransactions;
    use ResponseStructure;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function success_check_hash(): void
    {
        $res = $this->postJson(route('api.v1.set-translation'), SetTranslationTest::data());

        $hash = $res->json('data');

        $this->getJson(route('api.v1.check-hash', [
            "key" => Hash::KEY_APP_TRANSLATION,
            "hash" => $hash
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse(true))
        ;
    }

    /** @test */
    public function success_wrong_hash(): void
    {
        $res = $this->postJson(route('api.v1.set-translation'), SetTranslationTest::data());

        $hash = $res->json('data');

        $this->getJson(route('api.v1.check-hash', [
            "key" => Hash::KEY_APP_TRANSLATION,
            "hash" => 'some_hash'
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse(false))
        ;
    }

    /** @test */
    public function fail_not_exist_hash(): void
    {
        $this->getJson(route('api.v1.check-hash', [
            "key" => Hash::KEY_APP_TRANSLATION,
            "hash" => 'some_hash'
        ]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse(
                "Model [App\Models\Common\Hash] not found by [key = translation.app]"
            ))
        ;
    }

    /** @test */
    public function fail_wrong_key(): void
    {
        $this->getJson(route('api.v1.check-hash', [
            "key" => "wrong",
            "hash" => 'some_hash'
        ]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse(
                "Model [App\Models\Common\Hash] not found by [key = wrong]"
            ))
        ;
    }

    /** @test */
    public function fail_repo_return_exception()
    {
        $this->mock(HashRepository::class, function(MockInterface $mock){
            $mock->shouldReceive("getBy")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_BAD_REQUEST);
        });

        $this->postJson(route('api.v1.set-translation'), SetTranslationTest::data());

        $this->getJson(route('api.v1.check-hash', [
            "key" => "wrong",
            "hash" => 'some_hash'
        ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }
}
