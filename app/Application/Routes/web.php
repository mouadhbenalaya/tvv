<?php

use App\Application\Http\Controllers\HealthCheck;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return \response(
        \config('app.name') . ' ' . \config('setup.api.last_version'),
    );
})->name('web.version');

Route::get('status', HealthCheck::class)->name('web.status');
