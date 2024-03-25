<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        return response()->json($user, 201);
    }

    public function login(LoginRequest $request) {
        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Incorrect username or password"], 401);
        }

        $token = $user->createToken("AuthToken")->plainTextToken;

        return response()->json(["token" => $token]);
    }

    public function logout(Request $request) {
        // Token által hitelesített felhasználó lekérdezése
        // $user = $request->user();
        // $user = Auth::user();

        $user = auth()->user();
        /** @disregard P1013 Undefined method */
        $user->currentAccessToken()->delete();
        return response()->noContent();
    }

    public function logoutEverywhere() {
        $user = auth()->user();
        /** @disregard P1013 Undefined method */
        $user->tokens()->delete();
        return response()->noContent();
    }
}
