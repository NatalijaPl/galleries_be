<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            'first_name' => $validatedData["first_name"],
            'last_name' => $validatedData["last_name"],
            'email' => $validatedData["email"],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = auth()->login($user);

        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        return response()->json(
            array_merge(
                $this->responseWithToken($token),
                ['user' => $user]
            )
        );
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $credentials = [
            "email" => $validatedData['email'],
            "password" => $validatedData['password']
        ];

        $token = Auth::attempt($credentials);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        return response()->json($this->responseWithToken($token));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            "status" => "successfully logged out",
        ]);
    }

    protected function responseWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 5760
        ];
    }
}
