<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\MemberApiController;


Route::middleware(['auth:sanctum', 'role:admin,owner'])->group(function () {
    Route::get('/members', [MemberApiController::class, 'index']);
    Route::get('/members/{id}', [MemberApiController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/members', [MemberApiController::class, 'store']);
    Route::put('/members/{id}', [MemberApiController::class, 'update']);
    Route::patch('/members/{id}', [MemberApiController::class, 'update']);
    Route::delete('/members/{id}', [MemberApiController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| LOGIN API (Generate Token)
|--------------------------------------------------------------------------
*/
Route::post('/login', function (Request $request) {

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});

/*
|--------------------------------------------------------------------------
| PROTECTED SANCTUM API ROUTES
|--------------------------------------------------------------------------
*/


