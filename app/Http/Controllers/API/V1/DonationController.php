<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return Donation::all();
    }

    public function show($id)
    {
        return Donation::find($id);
    }

    public function store(Request $request)
    {
        return Donation::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Donation::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function destroy(Request $request, $id)
    {
        $article = Donation::findOrFail($id);
        $article->delete();

        return 204;
    }
}
