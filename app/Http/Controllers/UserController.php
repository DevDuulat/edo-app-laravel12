<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function generateTelegramToken(User $user)
    {
        $user->telegram_token = Str::random(32);
        $user->save();

        return back();
    }

    public function updateTelegram(Request $request, User $user)
    {
        $request->validate([
            'telegram_id' => 'nullable|string|max:255'
        ]);

        if ($request->telegram_id) {
            $user->telegram_id = $request->telegram_id;
        }

        if (!$user->telegram_token) {
            $user->telegram_token = bin2hex(random_bytes(5));
        }

        $user->save();

        return back()->with('success', 'Telegram данные обновлены');
    }

}
