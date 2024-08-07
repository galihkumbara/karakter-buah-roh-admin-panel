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
    public function store(Request $request)
    {
//         name:Marshall
// email:movierdo@student.ciputra.ac.id
// phone:08123456789
// institute:1
// city:3578
// education:1
// religion:2
// tribe:1
// password:wars1234
// password_confirmation:wars1234
// year_born:2000
// address:Jl. Mawar 123
// role:1
//request will contain above key and value, make member based on that
  
        if($request->password != $request->password_confirmation){
            return ResponseHelper::error('Password and password confirmation does not match', 422);
        }

        if(Member::where('email', $request->email)->first()){
            return ResponseHelper::error('Email already registered', 422);
        }

        //if member email is not in email format
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return ResponseHelper::error('Email is not in valid format', 422);
        }
        $photo = "";
        if($request->hasFile('photo')){
            //save to storage
            $photo = $request->file('photo')->store('public');
        }
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'institution_id' => $request->institute,
            'city_id' => $request->city,
            'education_id' => $request->education,
            'religion_id' => $request->religion,
            'ethnic_id' => $request->tribe,
            'password' => bcrypt($request->password),
            'birthdate' => $request->year_born . '-01-01',
            'address' => $request->address,
            'profile_picture_url' => $photo
        ]);
        $member->load('education')
        ->load('religion')
        ->load('member_modules')
        ->load('institution')
        ->load('city');


        //change 'profile_picture_url' key to 'photo'
        $member['photo'] = $member['profile_picture_url'];
        unset($member['profile_picture_url']);

        //birthdate to year_born

        $member['year_born'] = $member['birthdate']->format('Y');
        unset($member['birthdate']);

        //change 'institution' key to 'institute'
        $member['institute'] = $member['institution'];
        unset($member['institution']);

        //change ethnic key to tribe
        $member['tribe'] = $member['ethnic'];
        unset($member['ethnic']);

        //change module/is_active key to module/status
        $member['modules'] = $member['member_modules']->map(function($module){
        $module['status'] = $module['is_active'] ? 1 : 0;
        $module->load('module');
        $module['module']['color_hex'] = $module['module']['color'];
        $module['module']['order'] = $module['module']['order_number'];
        $module['module']['status'] = $module['module']['is_active'] ? 1 : 0;
        unset($module['module']['order_number']);
        unset($module['module']['color']);
        unset($module['is_active']);
        unset($module['module']['is_active']);
        unset($module['created_at']);
        unset($module['updated_at']); 
        unset($module['member_id']);
        unset($module['module_id']);
        return $module;
    });
    // unset($member['city']['province_id']);
        //atach first module to member
        $member->modules()->attach(1, ['is_active' => true]);
        return ResponseHelper::success($member);
    }

    /**
     * Display the specified resource.
     */ 
    public function show($member)
    {

               
        $member = Member::find($member)
                    ->load('education')
                    ->load('religion')
                    ->load('member_modules')
                    ->load('institution')
                    ->load('city');
            

        //change 'profile_picture_url' key to 'photo'
        $member['photo'] = $member['profile_picture_url'];
        unset($member['profile_picture_url']);

        //birthdate to year_born

        $member['year_born'] = $member['birthdate']->format('Y');
        unset($member['birthdate']);

        //change 'institution' key to 'institute'
        $member['institute'] = $member['institution'];
        unset($member['institution']);

        $member['institute_id'] = $member['institution_id'];
        unset($member['institution_id']);

        //change ethnic key to tribe
        $member['tribe'] = $member['ethnic'];
        unset($member['ethnic']);
        
        //change module/is_active key to module/status
        $member['modules'] = $member['member_modules']->map(function($module){
            $module['status'] = $module['is_active'] ? 1 : 0;
            $module->load('module');
            $module['module']['color_hex'] = $module['module']['color'];
            $module['module']['order'] = $module['module']['order_number'];
            $module['module']['status'] = $module['module']['is_active'] ? 1 : 0;
            unset($module['module']['order_number']);
            unset($module['module']['color']);
            unset($module['is_active']);
            unset($module['module']['is_active']);
            unset($module['created_at']);
            unset($module['updated_at']); 
            unset($module['member_id']);
            unset($module['module_id']);
            return $module;
        });
        unset($member['city']['province_id']);

        
        return ResponseHelper::success($member);
    }
    private $key = 'karakterbuahroh2024';
    public function forgotPassword(Request $request)
    {
        $member = Member::where('email', $request->email)->first();
        
        if(!$member){
            return ResponseHelper::error('Email not found', 404);
        }

        $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $member->password = bcrypt($newPassword);
        $member->save();

        return ResponseHelper::success(['new_password' => $newPassword]);
    }

    private function encrypt($data)
    {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($data, $cipher, $this->key, $options=0, $iv);
        return base64_encode($iv . $ciphertext);
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
       //if request has file 'photo'
       if($request->hasFile('photo')){
            //save to storage
            $path = $request->file('photo')->store('public');
            //change 'public' to 'storage'
            $path = str_replace('public', 'storage', $path);
            $member->profile_picture_url = $path;
       }

       
        if ($request->has('name')) {
            $member->name = $request->name;
        }
        
        if ($request->has('password')) {
            $member->password = bcrypt($request->password);
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

        if ($request->has('city_id')) {
            $member->city_id = $request->city_id;
        }

        if ($request->has('phone')) {
            $member->phone = $request->phone;
        }
        
        $member->save();

        $member                    ->load('education')
        ->load('religion')
        ->load('member_modules')
        ->load('institution')
        ->load('city');

  //change 'profile_picture_url' key to 'photo'
  $member['photo'] = $member['profile_picture_url'];
  unset($member['profile_picture_url']);

  //birthdate to year_born

  $member['year_born'] = $member['birthdate']->format('Y');
  unset($member['birthdate']);

  //change 'institution' key to 'institute'
  $member['institute'] = $member['institution'];
  unset($member['institution']);

  //change ethnic key to tribe
  $member['tribe'] = $member['ethnic'];
  unset($member['ethnic']);
  
  //change module/is_active key to module/status
  $member['modules'] = $member['member_modules']->map(function($module){
      $module['status'] = $module['is_active'] ? 1 : 0;
      $module->load('module');
      $module['module']['color_hex'] = $module['module']['color'];
      $module['module']['order'] = $module['module']['order_number'];
      $module['module']['status'] = $module['module']['is_active'] ? 1 : 0;
      unset($module['module']['order_number']);
      unset($module['module']['color']);
      unset($module['is_active']);
      unset($module['module']['is_active']);
      unset($module['created_at']);
      unset($module['updated_at']); 
      unset($module['member_id']);
      unset($module['module_id']);
      return $module;
  });
  unset($member['city']['province_id']);

  
        
        
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
        $member                    ->load('education')
        ->load('religion')
        ->load('member_modules')
        ->load('institution')
        ->load('city');

  //change 'profile_picture_url' key to 'photo'
  $member['photo'] = $member['profile_picture_url'];
  unset($member['profile_picture_url']);

  //birthdate to year_born

  $member['year_born'] = $member['birthdate']->format('Y');
  unset($member['birthdate']);

  //change 'institution' key to 'institute'
  $member['institute'] = $member['institution'];
  unset($member['institution']);

  //change ethnic key to tribe
  $member['tribe'] = $member['ethnic'];
  unset($member['ethnic']);
  
  //change module/is_active key to module/status
  $member['modules'] = $member['member_modules']->map(function($module){
      $module['status'] = $module['is_active'] ? 1 : 0;
      $module->load('module');
      $module['module']['color_hex'] = $module['module']['color'];
      $module['module']['order'] = $module['module']['order_number'];
      $module['module']['status'] = $module['module']['is_active'] ? 1 : 0;
      unset($module['module']['order_number']);
      unset($module['module']['color']);
      unset($module['is_active']);
      unset($module['module']['is_active']);
      unset($module['created_at']);
      unset($module['updated_at']); 
      unset($module['member_id']);
      unset($module['module_id']);
      return $module;
  });
  unset($member['city']['province_id']);

  
        return ResponseHelper::success($member->load('modules'));
    }
}
