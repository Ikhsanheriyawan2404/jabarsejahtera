<?php

namespace App\Http\Controllers\API\V1;

use App\{UserDetail, User};
use Laravel\Passport\Token;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserStoreRequest;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request)
    {
        $request->validated();
        try {
            DB::transaction(function () {
                $user = User::create([
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => password_hash(request('password'), PASSWORD_DEFAULT),
                ]);

                UserDetail::create([
                    'id' => $user->id,
                    'phone_number' => request('phone_number'),
                    'security_question' => request('security_question'),
                ]);
            });
        } catch (\Exception $e) {
            return new ApiResource(false, 'Error', $e);
        }
        return new ApiResource(true, 'Berhasil registrasi user.', null);
    }

    public function login()
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $data = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        if (!auth()->attempt($data)) {
            return new ApiResource(false, 'Username / password tidak cocok', null);
        }

        $token = auth()->user()->createToken('token')->accessToken;

        $data = [
            'token' => $token,
            'user' => auth()->user(),
        ];
        return new ApiResource(true, 'Berhasil login.', $data);
    }

    public function logout()
    {
        if (auth()->user()) {
            auth()->user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        }
        return new ApiResource(true, 'Berhasil logout.');
    }
}
