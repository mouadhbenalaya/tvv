<?php

declare(strict_types=1);

namespace App\Domain\Users\Routes;

use App\Common\Http\Controllers\AuditLog\CreateAuditLogController;
use App\Common\Http\Controllers\AuditLog\RetrieveAuditLogCollection;
use App\Common\Http\Controllers\Residency\RetrieveCity;
use App\Common\Http\Controllers\Residency\RetrieveCityCollection;
use App\Common\Http\Controllers\Residency\RetrieveCountry;
use App\Common\Http\Controllers\Residency\RetrieveCountryCollection;
use App\Common\Http\Controllers\Residency\RetrieveRegion;
use App\Common\Http\Controllers\Residency\RetrieveRegionCollection;
use Illuminate\Http\Response;
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

# AUDIT LOG ROUTES
Route::group([
    'prefix' => 'audit-logs',
    'middleware' =>  ['auth:sanctum'],
    'as' => 'audit-logs.'
], static function () {
    Route::post('/', CreateAuditLogController::class)->name('create');
    Route::get('/', RetrieveAuditLogCollection::class)->name('all');
});

# COUNTRY ROUTES
Route::prefix('countries')->name('countries.')->group(static function () {
    Route::get('/{country}', RetrieveCountry::class)->name('single');
    Route::get('/', RetrieveCountryCollection::class)->name('all');
});

Route::prefix('regions')->name('regions.')->group(static function () {
    Route::get('/{region}', RetrieveRegion::class)->name('single');
    Route::get('/', RetrieveRegionCollection::class)->name('all');
});

Route::prefix('cities')->name('cities.')->group(static function () {
    Route::get('/{city}', RetrieveCity::class)->name('single');
    Route::get('/', RetrieveCityCollection::class)->name('all');
});

Route::fallback(static fn () => \response()->json(['message' => 'Route not found.'], Response::HTTP_NOT_FOUND))->name('fallback');
