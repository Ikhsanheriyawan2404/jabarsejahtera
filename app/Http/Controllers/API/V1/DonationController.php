<?php

namespace App\Http\Controllers\API\V1;

use App\Donation;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PaginateResource;

class DonationController extends Controller
{
    public function index()
    {
        $title = request('title');
        $category = request('category');
        $donations = Donation::where('category', 'like', "%$category%")->where('title', 'like', "%$title%")->latest()->skip(10)->take(10)->paginate(10);

        // $offset = request()->has('offset') ? request()->get('offset') : 0;
        // $limit = request()->has('limit') ? request()->get('limit') : 10;
        // $donatons = Donation::limit($limit)->offset($offset)->get();
        // $totalCount = $donations->count();
        // $nextPage = url()->current() . '?offset=' . $offset * 2 . '&limit='.$limit;
        // return new PaginateResource(true, 'List Donation', $donatons, $totalCount, $nextPage);

        foreach ($donations as $donation) {
            $donation->image = $donation->image_path;
            $donation->total_budget = (int)$donation->total_budget;
        }

        return response()->json($donations, 200);
    }

    public function show($id)
    {
        $donation = Donation::with('transactions')->find($id);
        if ($donation) {
            $donation->image = $donation->image_path;
            return new ApiResource(true, 'Detai
            image
            unsplash-NuFUbftUu_s-unsplash.jpgls donation', $donation);
        }
        return response()->json(new ApiResource(false, 'Donasi tidak ditemukan', $donation), 404);

    }

    public function store(DonationRequest $request)
    {
        $request->validated();

        $donation = Donation::create([
            'title' => request('title'),
            'total_budget' => (int)request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
            'location' => request('location'),
            'image' => request()->file('image')->store('img/donations'),
        ]);

        $donation->image = $donation->image_path;
        return new ApiResource(true, 'Donasi Berhasil Ditambahkan', $donation);
    }

    public function update(DonationRequest $request, Donation $donation)
    {
        $request->validated();

        if (request('image')) {
            if ($donation->image !== 'img/default-banner.jpg') {
                Storage::delete($donation->image);
            }
            $image = request()->file('image')->store('img/donations');
        } else {
            $image = $donation->image;
        }

        $donation->update([
            'title' => request('title'),
            'total_budget' => request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
            'location' => request('location'),
            'image' => $image,
        ]);

        return new ApiResource(true, 'Donasi Berhasil Diedit', $donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        Storage::delete($donation->image);
        return new ApiResource(true, 'Data berhasil dihapus');
    }

}
