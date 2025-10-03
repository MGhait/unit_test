<?php

use App\Http\Controllers\APICategoryController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', APICategoryController::class);
});
