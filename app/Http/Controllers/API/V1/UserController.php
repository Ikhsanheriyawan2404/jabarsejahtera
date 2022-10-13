<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return new UserResource(true, 'List Users', User::with('user_detail')->get());
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource(true, 'Berhasil menghapus user');
    }
}
