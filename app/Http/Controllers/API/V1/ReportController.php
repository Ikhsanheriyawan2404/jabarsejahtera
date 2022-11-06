<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\{Report, Donation, Transaction};

class ReportController extends Controller
{
    public function zakat()
    {
        $start = Carbon::parse(request('start_date'))->format('Y-m-d');
        $end = Carbon::parse(request('end_date'))->format('Y-m-d');

        $zakat = Transaction::where('donation_id', NULL)->whereBetween('created_at', [$start, $end])->get();
        return response()->json(new ApiResource(true, 'List Pemasukan Zakat ', $zakat), 200);
    }

    public function donation()
    {
        $start = Carbon::parse(request('start_date'))->format('Y-m-d');
        $end = Carbon::parse(request('end_date'))->format('Y-m-d');

        $donation = Transaction::whereNotNull('donation_id')->whereBetween('created_at', [$start, $end])->get();
        return response()->json(new ApiResource(true, 'List Pemasukan Donasi', $donation), 200);
    }

    public function show(Donation $donation)
    {
        $reports = Report::where('donation_id', $donation->id)->orderBy('date', 'DESC')->get();
        return response()->json(new ApiResource(true, 'List Pengeluaran ' . $donation->title, $reports), 200);
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
