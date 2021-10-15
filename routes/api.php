<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::any('/desk_add_task', [ApiController::class, 'desk_add_task'])->name('desk_add_task');
Route::any('/desk_edit_task', [ApiController::class, 'desk_edit_task'])->name('desk_edit_task');
Route::any('/desk_add_ticket', [ApiController::class, 'desk_add_ticket'])->name('desk_add_ticket');
Route::any('/desk_edit_ticket', [ApiController::class, 'desk_edit_ticket'])->name('desk_edit_ticket');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

