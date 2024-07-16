<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreMemberModuleRequest;
use App\Http\Requests\UpdateMemberModuleRequest;
use App\Models\Member;
use App\Models\MemberModule;
use Illuminate\Http\Request;

class MemberModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memberId = $request->input('member_id');
        if($memberId) {
            if(Member::find($memberId) == null) {
                return ResponseHelper::error('Member not found', 404);
            }
            $memberModules = MemberModule::where('member_id', $memberId)->get();
        } else {
            $memberModules = MemberModule::all();
        }

        //get only Module object from each MemberModule
        $modules = $memberModules->map(function($memberModule){
            return $memberModule->module;
        });

        return ResponseHelper::success($modules);

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
    public function store(StoreMemberModuleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberModule $memberModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberModuleRequest $request, MemberModule $memberModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberModule $memberModule)
    {
        //
    }
}
