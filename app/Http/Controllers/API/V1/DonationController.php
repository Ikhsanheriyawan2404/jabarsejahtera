<?php

namespace App\Http\Controllers\API\V1;

use App\Donation;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function index()
    {
        $categories = Donation::latest()->get();
        return new DonationResource(true, 'List Categories', $categories);
    }

    public function show(Donation $donation)
    {
        return new DonationResource(true, 'Details donation', $donation);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation = Donation::create([
            'name'     => request('name'),
        ]);

        return new DonationResource(true, 'Data Category Berhasil Ditambahkan!', $donation);
    }

    public function update(Donation $donation)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $donation->update([
            'name'     => request('name'),
        ]);

        return new DonationResource(true, 'Data DOnasi Berhasil deidt!', $donation);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return new DonationResource(true, 'Data berhasil dihapus', null);
    }

}
