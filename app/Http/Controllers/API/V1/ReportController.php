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
        if (request('start_date') && request('end_date')) {
            $start = Carbon::parse(request('start_date'))->format('Y-m-d');
            $end = Carbon::parse(request('end_date'))->format('Y-m-d');
        } else {
            $start = Carbon::now()->subDays(6)->format('Y-m-d');
            $end = Carbon::now()->addDay()->format('Y-m-d');
        }

        $zakat = Transaction::where('donation_id', NULL)->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
        return response()->json(new ApiResource(true, 'List Pemasukan Zakat', $zakat), 200);
    }

    public function donation()
    {
        if (request('start_date') && request('end_date')) {
            $start = Carbon::parse(request('start_date'))->format('Y-m-d');
            $end = Carbon::parse(request('end_date'))->format('Y-m-d');
        } else {
            $start = Carbon::now()->subDays(6)->format('Y-m-d');
            $end = Carbon::now()->addDay()->format('Y-m-d');
        }

        $donation = Transaction::whereNotNull('donation_id')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
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

    public function expend()
    {
        if (request('start_date') && request('end_date')) {
            $start = Carbon::parse(request('start_date'))->format('Y-m-d');
            $end = Carbon::parse(request('end_date'))->format('Y-m-d');
        } else {
            $start = Carbon::now()->subDays(6)->format('Y-m-d');
            $end = Carbon::now()->addDay()->format('Y-m-d');
        }

        $donation = Report::with('donation')->where('date', '>=', $start)->where('date', '<=', $end)->get();
        return response()->json(new ApiResource(true, 'List Pengeluaran Donasi', $donation), 200);
    }
}
