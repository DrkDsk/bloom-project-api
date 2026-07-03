<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\FirebasePushNotification;

class FcmController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = User::query()->firstOrCreate(
            ['email' => $request->email],
            [
                'password' => Hash::make($request->password),
                'name' => $request->email,
            ]
        );

        $user->devices()->updateOrCreate(
            ['device_id' => $request->device_id],
            [
                'platform' => $request->platform,
                'fcm_token' => $request->fcm_token,
                'device_name' => $request->device_name,
                'last_seen_at' => now(),
                'is_active' => true,
            ]
        );

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $device = $user->devices()->first();

        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        return response()->json([
            'message' => 'Login successful token',
            'token' => $device->fcm_token,
        ]);
    }

    public function trigger(Request $request): JsonResponse
    {
        $email = $request->email;

        $user = User::query()->firstWhere('email', $email);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->notify(new FirebasePushNotification());

        return response()->json(['message' => 'Emergency notification sent']);
    }
}
