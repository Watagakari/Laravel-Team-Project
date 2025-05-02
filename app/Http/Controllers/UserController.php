<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        $UserInput = $request-> validate([
            'loginname' => 'required',
            'loginpassword' => 'required',
        ]);

        if(auth()->attempt(['name' => $UserInput['loginname'], 'password' => $UserInput['loginpassword']])){
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }
    public function register(Request $request){
        $UserInput = $request->validate([
            'name' => ['required', 'min:3', 'max:45', Rule::unique('users','name')],
            'email'=> ['required', 'email',Rule::unique('users','email')],
            'password'=> ['required', 'min:6', 'max:16'],
        ]);
        
        $UserInput['password'] = bcrypt($UserInput['password']);
        $user = User ::create($UserInput);
        auth()->login($user);
        return redirect('/');
    }


}
