<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Religion;
use App\Http\Requests\StoreReligionRequest;
use App\Http\Requests\UpdateReligionRequest;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(Religion::all()->sortBy('name')->values());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReligionRequest $request)
    {
        $name = $request->name;

        $religion = Religion::create([
            'name' => $name,
        ]);

        return ResponseHelper::success($religion);
    }

    /**
     * Display the specified resource.
     */
    public function show(Religion $religion)
    {
        if (!$religion) {
            return ResponseHelper::error('Religion not found',404);
        }
        return ResponseHelper::success($religion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Religion $religion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReligionRequest $request, Religion $religion)
    {
        $religion->update([
            'name' => $request->name,
        ]);

        return ResponseHelper::success($religion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Religion $religion)
    {
        $religion->delete();
        return ResponseHelper::success('Religion deleted successfully ');
    }
}
