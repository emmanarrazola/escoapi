<?php

use Illuminate\Support\Facades\Route;

/* Desk */
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\ZohoApiController;
use App\Http\Controllers\ZohoDeskDeptController;
use App\Http\Controllers\ZohoDeskAgentController;
use App\Http\Controllers\ZohoDeskTicketController;
use App\Http\Controllers\ZohoDeskAccountController;
use App\Http\Controllers\ParametersController;

/* Inventory */
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WarehouseController;

/* CRM */
use App\Http\Controllers\DealsController;

/* API*/
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});



Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('scopes', ScopeController::class);
    Route::resource('zohoapi', ZohoApiController::class);
    Route::resource('desk_departments', ZohoDeskDeptController::class);
    Route::resource('desk_agents', ZohoDeskAgentController::class);
    Route::resource('parameters', ParametersController::class);
    Route::resource('desk_tickets', ZohoDeskTicketController::class);
    Route::resource('desk_accounts', ZohoDeskAccountController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('crm_deals', DealsController::class);

    Route::resource('items', ItemController::class);

    Route::get('/apiauth', [ApiAuthController::class, 'index'])->name('apiauth');
});

Route::get('/get_zoho_tickets', [ApiController::class, 'get_zoho_tickets'])->name('get_zoho_tickets');
Route::get('/get_crm_deals', [ApiController::class, 'get_crm_deals'])->name('get_crm_deals');
Route::get('/zoho_form_webhooks', [ApiController::class, 'zoho_form_webhooks'])->name('zoho_form_webhooks');




require __DIR__.'/auth.php';
