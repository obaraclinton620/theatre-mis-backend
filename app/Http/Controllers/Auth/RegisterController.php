<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'production_id' => 'required|exists:productions,id',
            'full_name'     => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|confirmed',
        ]);

        $user = User::create([
            'production_id' => $data['production_id'],
            'full_name'     => $data['full_name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }
}
