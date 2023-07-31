<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SorterController;
use App\Http\Controllers\Auth\LoginController;

Route::post('/login' , [LoginController::class,'login']);
Route::post('/register/users', [UserController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/user', [UserController::class, 'user']);

    Route::get('/customers/{user_id}', [CustomerController::class, 'fetchCustomers']);
    Route::get('/sorters/{user_id}', [SorterController::class, 'fetchSorters']);

    Route::post('/add/customer', [CustomerController::class, 'addCustomer']);
    Route::post('/add/sorter', [SorterController::class, 'addSorter']);

});

Route::get('/companies', [UserController::class, 'getCompaniesInfo']);