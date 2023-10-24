<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        // $token = $user->createToken('API_TOKEN')->plainTextToken;

        $response = [
            'user' => $user,
            // 'API_TOKEN' => $token
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //check if user exists
        $user = User::where('email', $fields['email'])->first();
        //check for password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'invalid user'
            ], 401);
        }
        //create access token
        $token = $user->createToken('API_TOKEN')->plainTextToken;
        $response = [
            'user' => $user,
            'API_TOKEN' => $token,
        ];
        return response($response, 201);
    }
    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'logged out'
        ];
    }
}
