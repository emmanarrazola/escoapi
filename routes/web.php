<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ScopeController;
use App\Http\Controllers\ZohoApiController;
use App\Http\Controllers\ZohoDeskDeptController;
use App\Http\Controllers\ZohoDeskAgentController;
use App\Http\Controllers\ZohoDeskTicketController;
use App\Http\Controllers\ZohoDeskAccountController;
use App\Http\Controllers\ParametersController;
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

    Route::get('/apiauth', [ApiAuthController::class, 'index'])->name('apiauth');
});

Route::get('/get_zoho_tickets', [ApiController::class, 'get_zoho_tickets'])->name('get_zoho_tickets');



require __DIR__.'/auth.php';
