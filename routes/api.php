<?php
use App\Http\Controllers\SsoController;

Route::get('/sso/verify', [SsoController::class, 'verify']);
