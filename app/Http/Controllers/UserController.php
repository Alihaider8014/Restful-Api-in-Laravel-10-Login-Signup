<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Str;
use Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $response    = ['error' => true, 'message' => 'Invalid credentials'];
        $status_code = 400;
        $user        = $request->user;
        $password    = $request->password;
        if(Hash::check($password, $user->password)){
            $response = [
                'name'   => $user->first_name . $user->last_name,
                'source' => $user->source,
                'token'  => Str::random(200)
            ];
            $status_code = 200;
        }
        return response()->json($response, $status_code);
    }
    public function register(SignUpRequest $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'source'     => $request->source,
            'email'      => strtolower($request->email),
            'password'   => Hash::make($request->password),
            'dob'        => $request->dob,
        ]);
        return response()->json(['error' => false, 'message' => 'Login Successfully'],200);
    }
}
