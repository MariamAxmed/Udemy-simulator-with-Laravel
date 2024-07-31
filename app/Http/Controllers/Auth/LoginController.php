<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MailRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response([
                'message' => 'Email ve ya parol sehvdir!',
                'data' => [
                    'data' => null
                ]
            ], 400);
        }

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        $token = $user->createToken('user_token', ['*'], Carbon::now()->addMinutes(15))->plainTextToken;
        return response([
            'message' => 'Girish ugurlu',
            'data' => [
                'token' => $token,
                'user'=> $user
            ]
        ], 201);


    }

}
