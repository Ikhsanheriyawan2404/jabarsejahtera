<?php

namespace App\Http\Controllers\API\V1;

use App\{UserDetail, User};
use Illuminate\Support\Facades\DB;
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
                    // 'image' => request()->file('image')->store('img/users')
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(false, 'Error', $e), 400);
        }
        return new ApiResource(true, 'Berhasil registrasi user.', null);
    }

    public function login()
    {
        request()->validate([
            'email'=> 'required',
            'password'=> 'required',
        ]);

        $data = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        if (!auth()->attempt($data)) {
            return response()->json(new ApiResource(false, 'Username / password tidak cocok', null), 401);
        }

        if(Auth::check()){
            auth()->user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        };

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
