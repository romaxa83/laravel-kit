<?php

namespace Tests\Feature\Api\V1\Localization\Translation;

use App\Models\Localization\Language;
use App\Repositories\Localization\TranslationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\Builder\Localization\TranslationBuilder;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class GetTranslationTest extends TestCase
{
    use DatabaseTransactions;
    use ResponseStructure;

    protected $translationBuilder;

    public function setUp(): void
    {
        parent::setUp();
        $this->translationBuilder = resolve(TranslationBuilder::class);
    }

    /** @test */
    public function success(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();

        $this->getJson(route('api.v1.get-translation'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "text" => $t_3->text,
                ],
                "ua" => [
                    "button" => $t_2->text,
                    "text" => $t_4->text,
                ]
            ]))
            ->assertJsonCount(2, 'data')
        ;
    }

    /** @test */
    public function success_by_lang(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();

        $this->getJson(route('api.v1.get-translation', ["lang" => "en"]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "text" => $t_3->text,
                ],
            ]))
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_by_few_langs(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ru"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();
        $t_5 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_6 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ru"])->create();

        $this->getJson(route('api.v1.get-translation', ["lang" => ["en", 'ru']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "text" => $t_5->text,
                ],
                "ru" => [
                    "button" => $t_3->text,
                    "text" => $t_6->text,
                ],
            ]))
            ->assertJsonCount(2, 'data')
        ;
    }

    /** @test */
    public function success_by_few_langs_but_not_active(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'button', "lang" => "pl"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();
        $t_5 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_6 = $this->translationBuilder->setData(["key" => 'text', "lang" => "pl"])->create();

        $langPl = Language::query()->where('slug', 'pl')->first();

        $this->assertFalse($langPl->isActive());

        $this->getJson(route('api.v1.get-translation', ["lang" => ["en", 'pl']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "text" => $t_5->text,
                ],
            ]))
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_by_few_langs_but_not_exist_lang(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'button', "lang" => "kk"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();
        $t_5 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_6 = $this->translationBuilder->setData(["key" => 'text', "lang" => "kk"])->create();

        $langKk = Language::query()->where('slug', 'kk')->first();

        $this->assertNull($langKk);

        $this->getJson(route('api.v1.get-translation', ["lang" => ["en", 'kk']]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "text" => $t_5->text,
                ],
            ]))
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_by_key(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();

        $this->getJson(route('api.v1.get-translation', ["key" => "button"]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                ],
                "ua" => [
                    "button" => $t_2->text,
                ],
            ]))
            ->assertJsonCount(2, 'data')
            ->assertJsonCount(1, 'data.en')
            ->assertJsonCount(1, 'data.ua')
        ;
    }

    /** @test */
    public function success_by_few_keys(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();
        $t_5 = $this->translationBuilder->setData(["key" => 'alert', "lang" => "en"])->create();
        $t_6 = $this->translationBuilder->setData(["key" => 'alert', "lang" => "ua"])->create();

        $this->getJson(route('api.v1.get-translation', ["key" => ["button", "alert"]]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "alert" => $t_5->text,
                ],
                "ua" => [
                    "button" => $t_2->text,
                    "alert" => $t_6->text,
                ],
            ]))
            ->assertJsonCount(2, 'data')
            ->assertJsonCount(2, 'data.en')
            ->assertJsonCount(2, 'data.ua')
        ;
    }

    /** @test */
    public function success_by_few_keys_not_exist(): void
    {
        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();
        $t_3 = $this->translationBuilder->setData(["key" => 'text', "lang" => "en"])->create();
        $t_4 = $this->translationBuilder->setData(["key" => 'text', "lang" => "ua"])->create();
        $t_5 = $this->translationBuilder->setData(["key" => 'alert', "lang" => "en"])->create();
        $t_6 = $this->translationBuilder->setData(["key" => 'alert', "lang" => "ua"])->create();

        $this->getJson(route('api.v1.get-translation', ["key" => ["button", "alert", "test"]]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                "en" => [
                    "button" => $t_1->text,
                    "alert" => $t_5->text,
                ],
                "ua" => [
                    "button" => $t_2->text,
                    "alert" => $t_6->text,
                ],
            ]))
            ->assertJsonCount(2, 'data')
            ->assertJsonCount(2, 'data.en')
            ->assertJsonCount(2, 'data.ua')
        ;
    }

    /** @test */
    public function fail_report_return_exception()
    {
        $this->mock(TranslationRepository::class, function(MockInterface $mock){
            $mock->shouldReceive("getForApp")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_BAD_REQUEST);
        });

        $this->getJson(route('api.v1.get-translation'))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }
}
