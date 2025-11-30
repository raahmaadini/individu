<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\MemberApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('members', MemberApiController::class);

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


