<?php

namespace App\Http\Controllers\API\V1;

use App\{UserDetail, User};
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;

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
                    'user_id' => $user->id,
                    'phone_number' => request('phone_number'),
                ]);
            });
        } catch (\Exception $e) {
            return new UserResource(false, false, 'Error', $e);
        }
        return new UserResource(true, 'Berhasil registrasi user.', null);
    }

    public function login() {}

    public function logout() {}
}
