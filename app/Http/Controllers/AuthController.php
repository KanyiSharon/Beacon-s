<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registerGet()
    {
        if(Auth::check()){
            return redirect(route('example.fetch'));
        }
        $roles = Role::select('role')->get();
        $genders = Gender::select('gender')->get();

        return view('register', compact('roles', 'genders'));
    }

    function registerPost(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:staff',
            'phone' => 'required',
            'password' => 'required',
            'confirmpassword' => 'required'
        ]);
        $data['fullname'] = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname
        ];
        $data['gender_id'] = Gender::where('gender',$request->gender)->value('id');
        $data['telephone']=$request->phone;
        $data['staff_no']=Str::uuid();
        $data['role_id'] = Role::where('role',$request->role)->value('id');
        $data['email'] = $request->email;
        if (strcmp($request->password, $request->confirmpassword) == 0) {
            $data['password'] = Hash::make($request->confirmpassword);
        }
        $staff = User::create($data);
        if(!$staff){
            return redirect(route('register.post'))->with('error','Registration Failed. Try again later!');
        }
        return redirect(route('register.post'))->with('success','Registration Successful');
    }

    function loginGet()
    {
        if(Auth::check()){
            return redirect(route('example.fetch'));
        }
        return view('login');
    }

    function loginPost(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('example.fetch'));
        }
        return redirect(route('login.post'))->with('error','Credentials are not valid!')->withInput($request->except('password'));
    }
}
