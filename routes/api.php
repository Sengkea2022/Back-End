<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;


Route::post('/login', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('name', $request->name)->first();
    $token = $user->createToken('api-token')->plainTextToken;

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    return response()->json([
        'message' => 'Logged in successfully',
        'user' => $user,
        'token' => $token
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
