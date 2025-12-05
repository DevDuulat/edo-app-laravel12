<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateTelegram(Request $request, User $user)
    {
        $request->validate([
            'telegram_username' => 'nullable|string|max:255'
        ]);

        $user->telegram_username = $request->telegram_username;
        $user->save();

        return back()->with('success', 'Telegram username обновлен');
    }

}
