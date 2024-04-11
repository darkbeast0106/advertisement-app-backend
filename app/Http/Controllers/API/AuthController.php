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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     operationId="login",
     *     summary="Login",
     *     description="Bejelentkezés a rendszerbe",
     *     @OA\RequestBody(
     *         description="Bejelentkezési adatok",
     *         required=true,
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Examples(example="teszt",
     *               value={"email": "teszt@example.com", "password": "asdf1234" },
     *               summary="Teszt Elek"
     *              ),
     *              @OA\Examples(example="gipsz",
     *               value={"email": "gipsz@example.com", "password": "asdf1234" },
     *               summary="Gipsz Jakab"
     *              ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Hibás felhasználónév vagy jelszó",
     *     )
     * )
     */
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
