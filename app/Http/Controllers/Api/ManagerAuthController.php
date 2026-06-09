<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $manager = Manager::where('email', $request->email)->first();

        if (!$manager || !Hash::check($request->password, $manager->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $manager->createToken('client-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'manager'  => $manager
        ]);
    }

    public function dashboard()
    {
        return response()->json([
            'user' => auth('manager')->user()
        ]);
    }

    public function logout(Request $request)
    {
        // auth('manager')->user()
        //     ->currentAccessToken()
        //     ->delete();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }
}
