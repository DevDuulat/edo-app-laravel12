<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
