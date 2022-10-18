<?php

namespace App\Http\Controllers\API\V1;

use App\Donation;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->paginate(10);
        return new ApiResource(true, 'List Donation', $donations);
    }

    public function show($id)
    {
        $donation = Donation::find($id);
        if ($donation) {
            return new ApiResource(true, 'Details donation', $donation);
        }
        return response()->json(new ApiResource(false, 'Donasi tidak ditemukan'), 404);
    }

    public function store(DonationRequest $request)
    {
        $request->validated();

        $donation = Donation::create([
            'title' => request('title'),
            'total_budget' => request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
            'image' => request()->file('image')->store('img/donations'),
        ]);

        return new ApiResource(true, 'Donasi Berhasil Ditambahkan', $donation);
    }

    public function update(DonationRequest $request, Donation $donation)
    {
        $request->validated();

        if (request('image')) {
            Storage::delete($donation->image);
            $image = request()->file('image')->store('img/donations');
        } else {
            $image = $donation->image;
        }

        $donation->update([
            'title' => request('title'),
            'total_budget' => request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
            'image' => $image,
        ]);

        return new ApiResource(true, 'Donasi Berhasil Diedit', $donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return new ApiResource(true, 'Data berhasil dihapus', null);
    }

}
