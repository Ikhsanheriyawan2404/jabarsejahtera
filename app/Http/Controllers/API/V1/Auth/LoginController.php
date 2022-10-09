<?php

namespace App\Http\Controllers\API\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            return (new UserResource(true, 'Berhasil Login', $user))->additional([
                'token' => $user->createToken('myAppToken')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Your credential does not match.',
        ], 401);
    }
}
