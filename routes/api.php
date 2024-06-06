<?php

use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\TourController;
use App\Http\Controllers\Api\CardNumberController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\FiltersController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\V1\AuthenticateController;
use App\Http\Controllers\Api\V1\ChallengeController;
use App\Http\Controllers\Api\V1\MethodUrlController;
use App\Http\Controllers\Api\V1\NotificationServiceController;
use App\Http\Controllers\Api\V1\OTPController;
use App\Http\Middleware\CustomValidateSignature;
use App\Http\Middleware\LogIncomingRequest;
use App\Http\Middleware\SetFormUrlEncoded;
use App\Http\Middleware\SetUpIssuerService;
use App\Http\Middleware\TranslateFormUrlEncoded;
use App\Http\Middleware\ValidateCardRange;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])
    ->prefix('admin')
    ->name('api.admin.')
    ->group(base_path('routes/admin/api.php'));

Route::prefix('v1')->group(function () {
    Route::post('authenticate', [AuthenticateController::class, 'store'])
        ->name('v1.authenticate')
        ->middleware([
            LogIncomingRequest::class,
            ValidateCardRange::class,
        ]);

    Route::post('challenge/{transaction}', [ChallengeController::class, 'store'])
        ->name('v1.challenge')
        ->middleware([
            LogIncomingRequest::class,
            TranslateFormUrlEncoded::class,
            SetUpIssuerService::class,
            ValidateSignature::class,
        ]);

    Route::post('challenge-response/{transaction}', [ChallengeController::class, 'store'])
        ->name('v1.challenge-response')
        ->middleware([
            LogIncomingRequest::class,
            TranslateFormUrlEncoded::class,
            ValidateSignature::class,
        ]);

    Route::post('otp-send', [OTPController::class, 'sendOtp'])
        ->name('v1.otp-send')
        ->middleware([
            LogIncomingRequest::class,
        ]);

    Route::get('challenge-cancel/{transaction}', [ChallengeController::class, 'store'])
        ->name('v1.challenge-cancel')
        ->middleware([
            SetFormUrlEncoded::class,
            LogIncomingRequest::class,
            TranslateFormUrlEncoded::class,
        ]);

    Route::post('method-url', [MethodUrlController::class, 'show'])
        ->name('v1.method-url');

    Route::post('store-device', [MethodUrlController::class, 'store'])
        ->name('v1.store-device');

    Route::post('oob-notification/{transaction}', [NotificationServiceController::class, 'notify'])
        ->name('v1.oob-notification')
        ->middleware([CustomValidateSignature::class]);

    Route::post('check-notified-transaction/{transaction}', [NotificationServiceController::class, 'check'])
        ->name('v1.check-status');
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('card-numbers/{transaction}/decrypt', [CardNumberController::class, 'decrypt'])
        ->name('card.decrypt');

    Route::get('emails/{transaction}/decrypt', [EmailController::class, 'decrypt'])
        ->name('emails.decrypt');

    Route::get('settings/select', [SettingController::class, 'selectOptions'])
        ->name('api.settings.select');

    Route::get('settings/select-settings', [SettingController::class, 'selectSettings'])
        ->name('api.settings.select.settings');

    Route::post('reports', [ReportController::class, 'store'])
        ->name('api.reports.store');

    Route::get('/countries', [FiltersController::class, 'country'])->name('api.countries.index');
    Route::get('/issuers', [FiltersController::class, 'issuer'])->name('api.issuers.index');
    Route::get('/franchises', [FiltersController::class, 'franchise'])->name('api.franchises.index');
    Route::get('/currencies', [FiltersController::class, 'currency'])->name('api.currencies.index');

    Route::post('tours', [TourController::class, 'store'])
        ->name('api.tours.store');
});
