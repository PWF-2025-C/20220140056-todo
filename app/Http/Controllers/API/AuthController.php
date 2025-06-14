<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


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
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    #[Response(
        status: 200,
        content: [
            'status_code' => 200,
            'message' => 'Logout berhasil. Token telah dihapus.'
        ]
    )]
    #[Response(
        status: 500,
        content: [
            'status_code' => 500,
            'message' => 'Gagal logout. Terjadi kesalahan.'
        ]
    )]

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status_code' => 200,
                'message' => 'Logout berhasil. Token telah dihapus.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Gagal logout. Terjadi kesalahan.',
            ], 500);
        }
    }

}
