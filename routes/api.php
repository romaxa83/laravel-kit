<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\Localization;

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
Route::get('languages', [Localization\LanguageController::class, 'list'])
    ->name('api.v1.languages.list');
Route::get('languages/{id}', [Localization\LanguageController::class, 'one'])
    ->name('api.v1.languages.one');
Route::put('languages/{id}/toggle-active', [Localization\LanguageController::class, 'toggleActive'])
    ->name('api.v1.languages.toggle-active');
Route::get('translations', [Localization\TranslationController::class, 'setTranslation'])
    ->name('api.v1.set-translation');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('me', [Auth\AuthController::class, 'me'])
        ->name('api.v1.auth-user');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
