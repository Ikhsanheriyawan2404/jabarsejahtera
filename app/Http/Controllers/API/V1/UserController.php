<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        return new UserResource(true, 'List Users', User::with('user_detail')->get());
    }
}
