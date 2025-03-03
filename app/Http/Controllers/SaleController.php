<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\StoresaleRequest;
use App\Http\Requests\UpdatesaleRequest;
use App\Models\Sale;

use Illuminate\Support\Facades\DB;
class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $result = Sale::select('stores_id', DB::raw('SUM(customer_payment) as total_payment'))
        ->where('users_id', $id)
        ->groupBy('stores_id')
        ->orderBy('stores_id')
        ->get();


        return $result;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesaleRequest $request, sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sale $sale)
    {
        //
    }
}
