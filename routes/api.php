<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\Localization;
use App\Http\Controllers\Api\V1\Common;

Route::get('info', function(Request $request){
    return phpinfo();

//   return __('message.validation.not valid value', [
//       'value' => 'test',
//       'field' => 'test',
//   ]);
});

Route::post('sign-up', [Auth\AuthController::class, 'signUp'])->name('api.v1.sign-up');
Route::post('login', [Auth\AuthController::class, 'login'])->name('api.v1.login');

// Localization

//Route::controller(Localization\LanguageController::class)->group(function (){
//    Route::get('languages', 'list')->name('api.v1.languages.list');
//    Route::get('languages/{id}', 'one')->name('api.v1.languages.one');
//    Route::put('languages/{id}/toggle-active', 'toggleActive')->name('api.v1.languages.toggle-active');
//});

Route::get('languages', [Localization\LanguageController::class, 'list'])
    ->name('api.v1.languages.list');
Route::get('languages/{id}', [Localization\LanguageController::class, 'one'])
    ->name('api.v1.languages.one');
Route::put('languages/{id}/toggle-active', [Localization\LanguageController::class, 'toggleActive'])
    ->name('api.v1.languages.toggle-active');

Route::post('translations', [Localization\TranslationController::class, 'setTranslation'])
    ->name('api.v1.set-translation');
Route::get('translations', [Localization\TranslationController::class, 'getTranslation'])
    ->name('api.v1.get-translation');

Route::get('hash/{key}', [Common\HashController::class, 'getHash'])
    ->name('api.v1.get-hash');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('me', [Auth\AuthController::class, 'me'])
        ->name('api.v1.auth-user');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
