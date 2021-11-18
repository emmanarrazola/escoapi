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

/* ZOHO DESK */
Route::any('/desk_add_task', [ApiController::class, 'desk_add_task'])->name('desk_add_task');
Route::any('/desk_edit_task', [ApiController::class, 'desk_edit_task'])->name('desk_edit_task');
Route::any('/desk_delete_ticket', [ApiController::class, 'desk_delete_ticket'])->name('desk_delete_ticket');
Route::any('/desk_add_attachment', [ApiController::class, 'desk_add_attachment'])->name('desk_add_attachment');
Route::any('/desk_edit_attachment', [ApiController::class, 'desk_edit_attachment'])->name('desk_edit_attachment');
Route::any('/desk_delete_attachment', [ApiController::class, 'desk_delete_attachment'])->name('desk_delete_attachment');
/* CRM */
Route::any('/crm_add_deals', [ApiController::class, 'crm_add_deals'])->name('crm_add_deals');
Route::any('/crm_adit_deals', [ApiController::class, 'crm_adit_deals'])->name('crm_adit_deals');
Route::any('/crm_delete_deals', [ApiController::class, 'crm_delete_deals'])->name('crm_delete_deals');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

