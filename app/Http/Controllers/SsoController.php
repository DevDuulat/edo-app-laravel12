<?php

namespace App\Http\Controllers;

use App\Services\SsoService;
use Illuminate\Http\Request;

class SsoController extends Controller
{
    protected SsoService $ssoService;

    public function __construct(SsoService $ssoService)
    {
        $this->ssoService = $ssoService;
    }

    public function callback(Request $request)
    {
        $token = $request->query('token');

        $user = $this->ssoService->handleCallback($token);

        auth()->login($user);

        return redirect('/dashboard');
    }
}
