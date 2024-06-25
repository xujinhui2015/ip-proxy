<?php

use App\Http\Controllers\Api\ProxyController;
use Illuminate\Support\Facades\Route;

Route::get('/proxy/{key}', [ProxyController::class, 'index']);
