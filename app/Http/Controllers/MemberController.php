<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Member::all()
                    ->load('education')
                    ->load('religion')
                    ->load('ethnic')
                    ->load('institute');
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
    public function store(StoreMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */ 
    public function show(int $member)
    {
               
        $member = Member::find($member)
                    ->load('education')
                    ->load('religion')
                    ->load('modules')
                    ->load('institution');
            

        //change 'profile_picture_url' key to 'photo'
        $member['photo'] = $member['profile_picture_url'];
        unset($member['profile_picture_url']);

        //birthdate to year_born

        $member['year_born'] = $member['birthdate']->format('Y');
        unset($member['birthdate']);

        $member['phone'] = null;

        //change 'institution' key to 'institute'
        $member['institute'] = $member['institution'];
        unset($member['institution']);

        //change ethnic key to tribe
        $member['tribe'] = $member['ethnic'];
        unset($member['ethnic']);

        //change module/is_active key to module/status
        $member['modules'] = $member['modules']->map(function($module){
            $module['status'] = $module['pivot']['is_active'];
            $module['color_hex'] = $module['color'];
            $module['order'] = $module['order_number'];
            unset($module['order_number']);
            unset($module['color']);
            unset($module['is_active']);
            return $module;
        });

        
        return ResponseHelper::success($member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $member)
    {
        
        //it will send 
        //         name:hohosdsa
        // password:wars1234
        // year_born:2012
        // phone:213123123
        // address:adsadsads
        // institute_id:1
        // religion_id:1
        // tribe_id:1
        // city_id:1101
        // education_id:1
        // _method:PATCH

        //we need to map it to the correct key
        $member = Member::find($member);
        
        if ($request->has('name')) {
            $member->name = $request->name;
        }
        
        if ($request->has('password')) {
            $member->password = $request->password;
        }
        
        // Update birthdate only if year_born is present in the request
        if ($request->has('year_born')) {
            $member->birthdate = $request->year_born . '-01-01';
        }
        
        if ($request->has('address')) {
            $member->address = $request->address;
        }
        
        if ($request->has('institute_id')) {
            $member->institution_id = $request->institute_id;
        }
        
        if ($request->has('religion_id')) {
            $member->religion_id = $request->religion_id;
        }
        
        if ($request->has('tribe_id')) {
            $member->ethnic_id = $request->tribe_id;
        }
        
        if ($request->has('education_id')) {
            $member->education_id = $request->education_id;
        }
        
        $member->save();

        $member->load('education')
                ->load('religion')
                ->load('ethnic')
                ->load('institute')
                ->load('modules');

                   //change 'profile_picture_url' key to 'photo'
        $member['photo'] = $member['profile_picture_url'];
        unset($member['profile_picture_url']);

        //birthdate to year_born

        $member['year_born'] = $member['birthdate']->format('Y');
        unset($member['birthdate']);

        $member['phone'] = null;

        //change 'institution' key to 'institute'
        $member['institute'] = $member['institution'];
        unset($member['institution']);

        //change ethnic key to tribe
        $member['tribe'] = $member['ethnic'];
        unset($member['ethnic']);

        //change module/is_active key to module/status
        $member['modules'] = $member['modules']->map(function($module){
            $module['status'] = $module['pivot']['is_active'];
            $module['color_hex'] = $module['color'];
            $module['order'] = $module['order_number'];
            unset($module['order_number']);
            unset($module['color']);
            unset($module['is_active']);
            return $module;
        });
        return ResponseHelper::success($member);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

    public function addModuleToMember(Request $request, int $id){
        $member = Member::find($id);
        $member->modules()->attach($request->module_id, ['is_active' => true]);
        return ResponseHelper::success($member->load('modules'));
    }
}
