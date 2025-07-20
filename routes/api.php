<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('name', $request->name)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Instead of using sessions, return some API token or user info
    // For now, just return success message
    return response()->json(['message' => 'Logged in successfully', 'user' => $user]);
});