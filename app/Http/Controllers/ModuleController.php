<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Module;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = Module::all()->sortBy('order_number')
        ->map(function ($module) {
            $module['status'] = $module['is_active'] ? 1 : 0;
            unset($module['is_active']);
            $module['order'] = $module['order_number'];
            unset($module['order_number']);
            $module['color_hex'] = $module['color'];
            unset($module['color']);
            return $module;
        });
        return $module;
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
    public function store(StoreModuleRequest $request)
    {   
        $name = $request->name;
        $is_active = $request->status;
        $color = $request->hex_color;
        $price = 0;

        $module = Module::create([
            'name' => $name,
            'is_active' => $is_active,
            'color' => $color,
            'price' => $price
        ]);

        return ResponseHelper::success(  $module->load(['characters' => function($query) {
            $query->orderBy('order_number');
        }]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        if (!$module) {
            return ResponseHelper::error('Module not found',404);
        }
        //change is_active to status
        $module['status'] = $module['is_active'] ? 1 : 0;
        unset($module['is_active']);
        //change order_number to order
        $module['order'] = $module['order_number'];
        unset($module['order_number']);
        //change hex_color to color
        $module['color_hex'] = $module['color'];
        unset($module['color']);
        $module->load(['characters' => function($query) {
            $query->orderBy('order_number');
        }]);
        unset($module['created_at']);
        unset($module['updated_at']);
        
        foreach ($module->characters as $character) {
            $character['verse_number'] = $character['bible_verse'];
            unset($character['bible_verse']);
            $character['verse'] = $character['bible_verse_text'];
            unset($character['bible_verse_text']);
            $character['order'] = $character['order_number'];
            unset($character['order_number']);
            $character['status'] = $character['is_active'] ? 1 : 0;
            unset($character['is_active']);
            
        }
        return ResponseHelper::success($module);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModuleRequest $request, Module $module)
    {
        $name = $request->name;
        $is_active = $request->status;
        $color = $request->hex_color;

        //only update non-null fields
        if ($name) {
            $module->name = $name;
        }

        if ($is_active) {
            $module->is_active = $is_active;
        }

        if ($color) {
            $module->color = $color;
        }

        $module->save();

        return ResponseHelper::success($module);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        if (!$module) {
            return ResponseHelper::error('Module not found',404);
        }
        $module->delete();
        return ResponseHelper::success('Module deleted successfully');
    }
}
