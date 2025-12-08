<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\UserSyncController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/sso/verify', [SsoController::class, 'verify']);
Route::post('/sync-roles-permissions', [UserSyncController::class, 'syncRolesPermissions'])
    ->middleware('verify.sync.token');
Route::post('/sync-email', [UserSyncController::class, 'syncEmail'])
    ->middleware('verify.sync.token');

Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);
