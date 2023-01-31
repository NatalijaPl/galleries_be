<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        $user->load('gallery', 'gallery.images');
        return response()->json($user);
    }
}
