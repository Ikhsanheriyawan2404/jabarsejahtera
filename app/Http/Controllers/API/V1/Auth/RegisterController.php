<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [ 'required', 'string', 'email', 'max:255'],
            'password' => ['required','min:8']
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => password_hash(request('password'), PASSWORD_DEFAULT),
        ]);

        $token = $user->createToken('myAppToken');

        return (new UserResource(true, 'Berhasil menambah users', $user))->additional([
            'token' => $token->plainTextToken,
        ]);
    }
}
