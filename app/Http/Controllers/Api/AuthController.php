<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:user,email',
                'password' => 'required|min:8',
                'created_by' => 'required',
                'created_by_ip' => 'required',
                'phone' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "status" => "success",
                "message" => "User saved successfully",
                "data" => $user,
                "token" => $token
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                "status" => "error",
                "message" => "Validation failed. Error: " . $e->getMessage()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to save. Please try again. Error: " . $e->getMessage()
            ], 500);
        }

    }

    public function login(Request $request){

        //return $request;

        $credentials = request(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

}