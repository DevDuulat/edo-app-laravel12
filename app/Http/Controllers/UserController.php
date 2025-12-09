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


}
