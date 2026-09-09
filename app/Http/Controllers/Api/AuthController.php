<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        $user->last_login_at = now();
        $user->save();

        $user->refresh();

        \Log::info('Last login updated', [
            'user_id' => $user->id,
            'last_login_at' => $user->last_login_at,
        ]);

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => $user,
            'roles' => $user->roles->pluck('name'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.'
        ]);
    }
}