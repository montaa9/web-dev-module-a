<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function register(Request $request){
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users|string',
            'password' => 'required|confirmed|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if(!$validated){
            return response()->json(['message' => 'Validation error'], 400);
        }
        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);

    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('token');

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $request->user(),
                'token' => $token->plainTextToken
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ]);
    }

    public function user(Request $request) {
        $user = $request->user();

        return $user;
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
