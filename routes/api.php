<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', function(Request $request) {
    $credentials = $request->only('email', 'password');
   if (Auth::attempt($credentials)) {
       return response()->json(Auth::user());
   } else {
       return response()->json(['error' => 'Invalid login credentials'], 401);
   }
});

Route::post('logout', function(Request $request) {
    Auth::logout();
    return response()->json([
        'message' => 'Successfully logged out',
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('tickets')->group(function () {
        Route::get('open', [TicketController::class, 'open']);
        Route::get('closed', [TicketController::class, 'closed']);
    });

    Route::get('user', function (Request $request) {
        return $request->user();
    });
});


