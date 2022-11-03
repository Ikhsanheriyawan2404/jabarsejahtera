<?php

namespace App\Http\Controllers\API\V1;

use App\{User, UserDetail};
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        return new ApiResource(true, 'List Users', User::with('user_detail')->latest()->get());
    }

    public function show($id)
    {
        $user = User::with('user_detail')->find($id);
        $user->user_detail->image = $user->user_detail->image_path;
        if ($user) {
            return new ApiResource(true, 'Users', $user);
        }
        return response()->json(new ApiResource(false, 'User tidak ditemukan', $user), 404);
    }

    public function update($id, UserUpdateRequest $request)
    {
        if (auth()->user()->id == $id) {
            $user = User::find($id);
            $request->validated();
            try {
                if (request()->file('image')) {
                    if($user->user_detail->image !== 'img/default.jpg') {
                        Storage::delete($user->user_detail->image);
                    }
                    $image = request()->file('image')->store('img/users');
                } else {
                    $image = $user->user_detail->image;
                }

                DB::transaction(function () use ($user, $id, $image) {
                    $user->update([
                        'name' => request('name'),
                        'email' => request('email'),
                    ]);

                    UserDetail::where('id', $id)
                        ->update([
                        'phone_number' => request('phone_number'),
                        'image' => $image,
                    ]);
                });

            } catch (\Exception $e) {
                return new ApiResource(false, 'Error', $e);
            }

            return new ApiResource(true, 'Berhasil Update User');
        }
        return response()->json(new ApiResource(false, 'Gagal Update User', null), 403);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new ApiResource(true, 'Berhasil Menghapus User');
    }
}
