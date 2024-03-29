<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {

        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);

        } catch(\Exeption $ex) {
            return $response()->json([
                'error' => $ex.getMessaage(),
                'message' => 'Something went wrong in AuthController.register'
            ]);
        }
    }

    public function login(LoginRequest $request) {

        try {

            $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            if(Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('user_token')->plainTextToken;

                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 201);
            }

            return $response()->json([
                'error' => 'Something went wrong in AuthController.login'
            ]);

        } catch(\Exeption $ex) {
            return $response()->json([
                'error' => $ex.getMessaage(),
                'message' => 'Something went wrong in AuthController.login'
            ]);
        }
    }

    public function logout(LogoutRequest $request) {

        try {

            $user = User::findOrFail($request->input('user_id'));

            $user->tokens()->delete();

            return response()->json('User logged out', 200);

        } catch(\Exeption $ex) {
            return $response()->json([
                'error' => $ex.getMessaage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }
}
