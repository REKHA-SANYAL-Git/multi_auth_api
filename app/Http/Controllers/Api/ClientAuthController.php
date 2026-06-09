<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $client->createToken('client-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'client'  => $client
        ]);
    }

    public function dashboard()
    {
        return response()->json([
            'user' => auth('client')->user()
        ]);
    }

    public function logout(Request $request)
    {
        // auth('client')->user()
        //     ->currentAccessToken()
        //     ->delete();

        $request->user()->currentAccessToken()->delete();


        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }
}
