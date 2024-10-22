<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "status" => "success",
                "message" => "User saved successfully",
                "data" => $user,
                "token" => $token
            ], 201);
        } catch (ValidationException $e) {

            return response()->json([
                "status" => "error",
                "message" => "Validation failed. Error: " . $e->getMessage()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to save. Please try again. Error: " . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {

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
