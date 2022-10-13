<?php

namespace App\Http\Controllers\API\V1;

use App\Donation;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->get();
        return new DonationResource(true, 'List Donation', $donations);
    }

    public function show(Donation $donation)
    {
        if (!$donation) {
            return new DonationResource(false, 'Data tidak ditemukan');
        }
        return new DonationResource(true, 'Details donation', $donation);
    }

    public function store(DonationRequest $request)
    {
        $request->validated();

        $donation = Donation::create([
            'title' => request('title'),
            'total_budget' => request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
        ]);

        return new DonationResource(true, 'Donasi Berhasil Ditambahkan', $donation);
    }

    public function update(DonationRequest $request, Donation $donation)
    {
        // $request->validated();
        dd('fdas');

        $donation->update([
            'title' => request('title'),
            'total_budget' => request('total_budget'),
            'category' => request('category'),
            'description' => request('description'),
        ]);

        return new DonationResource(true, 'Donasi Berhasil Diedit', $donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return new DonationResource(true, 'Data berhasil dihapus', null);
    }

}
