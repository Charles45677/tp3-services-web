<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validation standard en ligne
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($credentials)) {
                throw new AuthenticationException();
            }

            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ]);
        } 
        catch (AuthenticationException $ex) {
            abort(401, "unauthorized");
        } 
        catch (ValidationException $ex) {
            abort(422, "invalid data");
        } 
        catch (Exception $ex) {
            abort(500, "server error");
        }
    }

    public function register(Request $request)
    {
        try {
            // Validation standard en ligne
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ], 21);
        } 
        catch (AuthenticationException $ex) {
            abort(401, "unauthorized");
        } 
        catch (ValidationException $ex) {
            abort(422, "invalid data");
        } 
        catch (Exception $ex) {
            abort(500, "server error");
        }
    }

    public function me(Request $request) 
    {
        try {
            if (!Auth::check()) {
                throw new AuthenticationException();
            }
            return response()->json(Auth::user());
        } 
        catch (AuthenticationException $ex) {
            abort(401, "unauthorized");
        } 
        catch (Exception $ex) {
            abort(500, "server error");
        }
    }

    public function refresh(Request $request) 
    {
        try {
            $user = $request->user();
            if (!$user) {
                throw new AuthenticationException();
            }
            
            // Recréation d'un jeton (Logique de type Sanctum)
            $user->tokens()->delete();
            return response()->json([
                'token' => $user->createToken('auth_token')->plainTextToken
            ]);
        } 
        catch (AuthenticationException $ex) {
            abort(401, "unauthorized");
        } 
        catch (Exception $ex) {
            abort(500, "server error");
        }
    }

    public function logout(Request $request) 
    {
        try {
            $user = $request->user();
            if (!$user) {
                throw new AuthenticationException();
            }

           
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } 
        catch (AuthenticationException $ex) {
            abort(401, "unauthorized");
        } 
        catch (Exception $ex) {
            abort(500, "server error");
        }
    }
}