<?php

namespace App\Http\Controllers\API\V1;

use App\{Report, Donation};
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function show(Donation $donation)
    {
        $reports = Report::where('donation_id', $donation->id)->orderBy('date', 'DESC')->get();
        return response()->json(new ApiResource(true, 'List Pengeluaran ' . $donation->title, $reports), 201);
    }

    public function store(Donation $donation)
    {
        request()->validate([
            'name' => 'required',
            'date' => 'required',
            'nominal' => 'required',
            'description' => 'required',
        ]);

        $report = Report::create([
            'donation_id' => $donation->id,
            'date' => request('date'),
            'nominal' => request('nominal'),
            'description' => request('description'),
            'name' => request('name'),
        ]);

        return response()->json(new ApiResource(true, 'Berhasil menambahkan pengeluaran', $report), 201);
    }
}
