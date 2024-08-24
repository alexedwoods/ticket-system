<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('tickets')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('open', [TicketController::class, 'open'])->name('tickets.open');
        Route::get('closed', [TicketController::class, 'closed'])->name('tickets.closed');
    });

    Route::get('/users/{email}/tickets', [TicketController::class, 'userTickets'])->name('users.tickets');

    Route::get('user', function (Request $request) {
        return $request->user();
    });
});

Route::get('stats', [TicketController::class, 'stats'])->name('tickets.stats');
