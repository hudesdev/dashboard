<?php

use App\Http\Middleware\AccessToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PingPingController;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => AccessToken::class], function () {
    Route::get('/', DashboardController::class);
});

Route::post('/pingping', PingPingController::class);
