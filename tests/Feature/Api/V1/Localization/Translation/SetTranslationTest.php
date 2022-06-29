<?php

namespace Tests\Feature\Api\V1\Localization\Translation;

use App\Models\Common\Hash;
use App\Models\Localization\Translation;
use App\Services\Localization\TranslationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\Builder\Localization\TranslationBuilder;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class SetTranslationTest extends TestCase
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
    public function success_set(): void
    {
        $data = self::data();

        $this->assertNull(
            Translation::query()->where([
                ['key', 'button'],
                ['lang', 'en'],
            ])->first()
        );
        $this->assertNull(
            Translation::query()->where([
                ['key', 'button'],
                ['lang', 'ua'],
            ])->first()
        );
        $this->assertNull(
            Translation::query()->where([
                ['key', 'text'],
                ['lang', 'en'],
            ])->first()
        );
        $this->assertNull(
            Translation::query()->where([
                ['key', 'text'],
                ['lang', 'ua'],
            ])->first()
        );

        $this->assertNull(Hash::query()->where('key', Hash::KEY_APP_TRANSLATION)->first());

        $res = $this->postJson(route('api.v1.set-translation'), $data)
            ->assertStatus(Response::HTTP_OK)
        ;

        $this->assertNotNull($modelHash = Hash::query()->where('key', Hash::KEY_APP_TRANSLATION)->first());
        $hash = Hash::generate(
            Translation::query()->select(['text', 'lang'])
                ->whereIn('place', [Translation::PLACE_APP])->toBase()->get()
        );

        $this->assertEquals($hash, $res->json('data'));
        $this->assertEquals($hash, $modelHash->hash);

        $t_1 = Translation::query()->where([
            ['key', 'button'],
            ['lang', 'en'],
        ])->first();
        $this->assertEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertEquals($t_1->place, Translation::PLACE_APP);

        $t_2 = Translation::query()->where([
            ['key', 'button'],
            ['lang', 'ua'],
        ])->first();
        $this->assertEquals($t_2->text, data_get($data, 'button.ua'));
        $this->assertEquals($t_2->place, Translation::PLACE_APP);

        $t_3 = Translation::query()->where([
            ['key', 'text'],
            ['lang', 'en'],
        ])->first();
        $this->assertEquals($t_3->text, data_get($data, 'text.en'));
        $this->assertEquals($t_3->place, Translation::PLACE_APP);

        $t_4 = Translation::query()->where([
            ['key', 'text'],
            ['lang', 'ua'],
        ])->first();
        $this->assertEquals($t_4->text, data_get($data, 'text.ua'));
        $this->assertEquals($t_4->place, Translation::PLACE_APP);
    }

    /** @test */
    public function success_update_or_create(): void
    {
        $data = self::data();

        $t_1 = $this->translationBuilder->setData(["key" => 'button', "lang" => "en"])->create();
        $t_2 = $this->translationBuilder->setData(["key" => 'button', "lang" => "ua"])->create();

        $this->assertNotEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertNotEquals($t_2->text, data_get($data, 'button.ua'));

        $this->assertNull(
            Translation::query()->where([
                ['key', 'text'],
                ['lang', 'en'],
            ])->first()
        );
        $this->assertNull(
            Translation::query()->where([
                ['key', 'text'],
                ['lang', 'ua'],
            ])->first()
        );

        $hashOld = Hash::generate(
            Translation::query()->select(['text', 'lang'])
                ->whereIn('place', [Translation::PLACE_APP])->toBase()->get()
        );

        $res =  $this->postJson(route('api.v1.set-translation'), $data)
            ->assertStatus(Response::HTTP_OK)
        ;

        $hashNew = Hash::generate(
            Translation::query()->select(['text', 'lang'])
                ->whereIn('place', [Translation::PLACE_APP])->toBase()->get()
        );

        $this->assertNotEquals($hashOld, $res->json('data'));
        $this->assertEquals($hashNew, $res->json('data'));

        $t_1->refresh();
        $t_2->refresh();

        $this->assertEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertEquals($t_2->text, data_get($data, 'button.ua'));

        $t_3 = Translation::query()->where([
            ['key', 'text'],
            ['lang', 'en'],
        ])->first();
        $this->assertEquals($t_3->text, data_get($data, 'text.en'));
        $this->assertEquals($t_3->place, Translation::PLACE_APP);

        $t_4 = Translation::query()->where([
            ['key', 'text'],
            ['lang', 'ua'],
        ])->first();
        $this->assertEquals($t_4->text, data_get($data, 'text.ua'));
        $this->assertEquals($t_4->place, Translation::PLACE_APP);

    }

    /** @test */
    public function success_update_one_locale()
    {
        $data = self::data();

        $t_1 = $this->translationBuilder->setData(['key' => 'button', "lang" => 'en'])->create();
        $t_2 = $this->translationBuilder->setData(['key' => 'button', "lang" => 'ua'])->create();

        $this->assertNotEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertNotEquals($t_2->text, data_get($data, 'button.ua'));

        unset($data['button']['ua']);

        $this->postJson(route('api.v1.set-translation'), $data)
            ->assertStatus(Response::HTTP_OK)
        ;

        $t_1->refresh();
        $t_2->refresh();

        $this->assertEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertNotEquals($t_2->text, data_get($data, 'button.ua'));
    }

    /** @test */
    public function success_empty()
    {
        $data = self::data();

        $t_1 = $this->translationBuilder->setData(['key' => 'button', "lang" => 'en'])->create();
        $t_2 = $this->translationBuilder->setData(['key' => 'button', "lang" => 'ua'])->create();

        $this->assertNotEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertNotEquals($t_2->text, data_get($data, 'button.ua'));

        $hash = Hash::generate(
            Translation::query()->select(['text', 'lang'])
                ->whereIn('place', [Translation::PLACE_APP])->toBase()->get()
        );

        $this->postJson(route('api.v1.set-translation'), [])
            ->assertJson($this->structureSuccessResponse($hash))
            ->assertStatus(Response::HTTP_OK)
        ;

        $t_1->refresh();
        $t_2->refresh();

        $this->assertNotEquals($t_1->text, data_get($data, 'button.en'));
        $this->assertNotEquals($t_2->text, data_get($data, 'button.ua'));
    }

    /** @test */
    public function fail_service_return_exception()
    {
        $this->mock(TranslationService::class, function(MockInterface $mock){
            $mock->shouldReceive("saveOrUpdate")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_BAD_REQUEST);
        });

        $this->postJson(route('api.v1.set-translation'), [])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }

    /** @test */
    public function fail_service_return_exception_without_code()
    {
        $this->mock(TranslationService::class, function(MockInterface $mock){
            $mock->shouldReceive("saveOrUpdate")
                ->andThrows(\Exception::class, "some exception message");
        });

        $this->postJson(route('api.v1.set-translation'), [])
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }

    public static function data(): array
    {
        return [
            'button' => [
                'en' => 'button en',
                'ua' => 'button ua'
            ],
            'text' => [
                'en' => 'text en',
                'ua' => 'text ua'
            ]
        ];
    }
}
