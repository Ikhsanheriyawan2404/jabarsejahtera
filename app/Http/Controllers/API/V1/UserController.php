<?php

namespace App\Http\Controllers\API\V1;

use App\{User, UserDetail};
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        return new ApiResource(true, 'List Users', User::with('user_detail')->latest()->get());
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return new ApiResource(true, 'Users', $user);
        }
        return response()->json(new ApiResource(false, 'User tidak ditemukan', $user), 404);
    }

    public function update($id, UserUpdateRequest $request)
    {
        $request->validated();
        $user = User::find($id);
        if (auth()->user()->id == $id) {
            try {
                DB::transaction(function () use ($user, $id) {
                    $user->update([
                        'name' => request('name'),
                        'email' => request('email'),
                    ]);

                    UserDetail::where('id', $id)
                        ->update([
                        'phone_number' => request('phone_number'),
                        'security_question' => request('security_question'),
                    ]);
                });
            } catch (\Exception $e) {
                return new ApiResource(false, 'Error', $e);
            }
            return new ApiResource(true, 'Berhasil Update User', null);
        }
        return response()->json(new ApiResource(false, 'Gagal Update User', null), 403);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new ApiResource(true, 'Berhasil Menghapus User');
    }
}
