<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Ethnic;
use App\Http\Requests\StoreEthnicRequest;
use App\Http\Requests\UpdateEthnicRequest;

class EthnicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(Ethnic::all());
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
    public function store(StoreEthnicRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ethnic $ethnic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ethnic $ethnic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEthnicRequest $request, Ethnic $ethnic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ethnic $ethnic)
    {
        //
    }
}
