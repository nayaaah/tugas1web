<?php

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->safe()->all();
            if(!Auth::attempt($validated)){
                return response()->json([
                    'message' => 'Login Gagal, Cek Kembali Email dan Password Anda'
                ], 401);
            }

            $user = $request->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login Berhasil',
                'access_token' => $token,
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login Gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

 public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->safe()->all();
            $passwordHash = Hash::make($validated['password']);
            $validated['password'] = $passwordHash;
            $response = User::create($validated);

            if ($response){
                return response()->json([
                    'message' => 'Registrasi Berhasil',
                    'data' => $response
                ], 201);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Registrasi Gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout Berhasil'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Logout Gagal',
                'error' => $e->getMessage()
            ], 500);}}
}