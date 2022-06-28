<?php

namespace Tests\Feature\Api\V1\Localization\Language;

use App\Models\Localization\Language;
use App\Repositories\Localization\LanguageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tests\Traits\ResponseStructure;

class ListTest extends TestCase
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
        $count = Language::count();

        $this->getJson(route('api.v1.languages.list'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure($this->structure([
                "id",
                "name",
                "native",
                "slug",
                "locale",
                "default",
                "active",
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_name(): void
    {
        $value = 'Englis';
        $count = Language::query()->where('name', 'like', $value . '%')->count();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'name' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_id(): void
    {
        $value = 1;
        $model = Language::query()->where('id', $value)->first();

        $this->getJson(route('api.v1.languages.list', [
            'id' => $value
        ]))
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $model->id,
                    "name" => $model->name
                ]
            ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_few_id(): void
    {
        $value = [1, 2];
        $count = Language::query()->whereIn('id', $value)->count();

        $this->getJson(route('api.v1.languages.list', [
            'id' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_slug(): void
    {
        $value = 'pl';
        $model = Language::query()->where('slug', $value)->first();

        $this->getJson(route('api.v1.languages.list', [
            'slug' => $value
        ]))
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $model->id,
                    "name" => $model->name
                ]
            ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_few_slug(): void
    {
        $value = ['ru', 'en'];
        $count = Language::query()->whereIn('slug', $value)->count();

        $this->getJson(route('api.v1.languages.list', [
            'slug' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_locale(): void
    {
        $value = 'uk_UA';
        $model = Language::query()->where('locale', $value)->first();

        $this->getJson(route('api.v1.languages.list', [
            'locale' => $value
        ]))
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $model->id,
                    "name" => $model->name
                ]
            ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_few_locale(): void
    {
        $value = ['es_ES', 'en_EN'];
        $count = Language::query()->whereIn('locale', $value)->count();

        $this->getJson(route('api.v1.languages.list', [
            'locale' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_active_true(): void
    {
        $value = true;
        $count = Language::query()->where('active',  $value)->count();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'active' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_active_false(): void
    {
        $value = false;
        $count = Language::query()->where('active',  $value)->count();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'active' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_filter_by_default(): void
    {
        $value = true;
        $count = Language::query()->where('default',  $value)->count();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'default' => $value
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_id_asc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('id',  'asc')->first();
        $last = Language::query()->orderBy('id',  'desc')->first();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'id',
            'order_type' => 'asc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $first->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_id_desc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('id',  'asc')->first();
        $last = Language::query()->orderBy('id',  'desc')->first();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'id',
            'order_type' => 'desc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $last->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_active_asc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('active',  'asc')->get();
        $last = Language::query()->orderBy('active',  'desc')->get();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'active',
            'order_type' => 'asc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $first->first()->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_active_desc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('active',  'asc')->get();
        $last = Language::query()->orderBy('active',  'desc')->get();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'active',
            'order_type' => 'desc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $last->first()->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_locale_asc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('locale',  'asc')->get();
        $last = Language::query()->orderBy('locale',  'desc')->get();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'locale',
            'order_type' => 'asc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $first->first()->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function success_order_by_locale_desc(): void
    {
        $count = Language::query()->count();
        $first = Language::query()->orderBy('locale',  'asc')->get();
        $last = Language::query()->orderBy('locale',  'desc')->get();

        $this->assertTrue($count > 0);

        $this->getJson(route('api.v1.languages.list', [
            'order_by' => 'locale',
            'order_type' => 'desc',
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($this->structureSuccessResponse([
                [
                    "id" => $last->first()->id
                ]
            ]))
            ->assertJsonCount($count, 'data')
        ;
    }

    /** @test */
    public function fail_repo_return_exception()
    {
        $this->mock(LanguageRepository::class, function(MockInterface $mock){
            $mock->shouldReceive("all")
                ->andThrows(\Exception::class, "some exception message", Response::HTTP_NOT_FOUND);
        });

        $this->getJson(route('api.v1.languages.list'))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson($this->structureErrorResponse("some exception message"))
        ;
    }
}

