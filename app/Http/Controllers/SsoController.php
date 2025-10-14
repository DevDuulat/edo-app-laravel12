<?php

namespace App\Http\Controllers;

use App\Services\SsoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    public function handleRedirect(SsoService $sso)
    {
        $user = Auth::user();
        $token = $sso->createToken($user);
        $url = config('services.sso.url') . '/sso-login?token=' . $token;

        return redirect()->away($url);
    }

    public function verify(Request $request)
    {
        $data = Cache::pull("sso_token_" . $request->token);
        if (!$data) {
            return response()->json(["error" => "invalid"], 403);
        }

        return response()->json($data);
    }

}
