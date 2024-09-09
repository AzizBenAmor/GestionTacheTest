<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where([
            'email' => $request->validated()['email'],
            'password' => $request->validated()['password'] ?? null,
        ])->first();
        if (!$user) {
            return response(
                [
                    'status' => 'failed',
                    'result' => 'Le mot de passe, identifiant ou le code saisi est incorrect.',
                ],
                404
            );
        }
        $authData = $request->only(['email', 'password']);

        if (
            !Auth::attempt($authData)
        ) {
            return response(
                [
                    'status' => 'failed',
                    'result' => 'Le mot de passe, identifiant ou le code saisi est incorrect.',
                ],
                404
            );
        }
        return response([
            'status' => 'success',
            'result' => $user + [
                'role' => data_get($user->getRoleNames(), 0),
            ],
        ], 200);
    }
}
