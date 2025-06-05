<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (empty($data['email']) || empty($data['password'])) {
            return response()->json([
                'success' => 400,
                'message' => 'Email and password are required.',
            ], 400);
        }
        try {
            if (!$token = Auth::guard('api')->attempt($data)) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Email atau password salah.',
                ], 401);
            }
            $user = Auth::guard('api')->user();
            return response()->json([
                'status_code' => 200,
                'message' => 'Login berhasil.',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_admin' => $user->is_admin,
                    ],
                    'token' => $token,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Logout berhasil.',
        ], 200);
    }
}
