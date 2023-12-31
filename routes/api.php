<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SorterController;
use App\Http\Controllers\BeanCounterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\GenerateMachineID;

Route::post('/login' , [LoginController::class,'login']);
Route::post('/register/users', [RegisterController::class, 'register']);
Route::post('/forget-password' , [ForgotPasswordController::class, 'forgetPassword']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/user', [UserController::class, 'user']);
    Route::patch('/update-user/{id}', [UserController::class, 'updateUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
    Route::patch('/disabled-user/{id}', [UserController::class, 'disabledUser']);
    Route::get('/allusers', [UserController::class, 'fetchUsers']);
    Route::post('/generate-keys', [UserController::class, 'generateRandomKey']);
    Route::get('/fetch-keys/{user_id}', [UserController::class, 'fetchRandomKey']);
    Route::delete('/delete-key/{id}', [UserController::class, 'deleteKey']);
    Route::post('/logout' , [LogoutController::class, 'logOut']);
    Route::get('/customers/{user_id}', [CustomerController::class, 'fetchCustomers']);
    Route::get('/sorters/{user_id}', [SorterController::class, 'fetchSorters']);

    Route::post('/generate-machineid' , [GenerateMachineID::class, 'generateMachineID']);
    Route::get('/fetch-machine-id/{user_id}' , [GenerateMachineID::class, 'fetchMachineID']);
    Route::patch('/machine-id/{id}', [UserController::class, 'setMachineId']);

    //Route::post('/add/customer', [CustomerController::class, 'addCustomer']);
    Route::post('/add/sorter', [SorterController::class, 'addSorter']);
    Route::patch('/edit/sorter/{id}', [SorterController::class, 'editSorter']);

    Route::patch('/edit-customer/{id}', [CustomerController::class, 'editCustomer']);
    Route::patch('/archive-customer/{id}', [CustomerController::class, 'archiveCustomer']);
    Route::get('/fetch-archive/{id}', [CustomerController::class, 'fetchArchiveds']);
    Route::get('/fetch-archive-status/{id}', [CustomerController::class, 'fetchStatusArchive']);
    Route::delete('/delete-archive-status/{id}', [CustomerController::class, 'deleteStatus']);
    Route::delete('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer']);

    Route::post('/add-info', [DetailsController::class, 'postDetails']);
    Route::patch('/edit-info/{user_id}', [DetailsController::class, 'editDetails']);
    Route::get('/fetch-info/{user_id}', [DetailsController::class, 'fetchDetails']);
    Route::get('/customer-receipt/{id}/{user_id}' , [StatusController::class, 'fetchStatusByCustomer']);

    Route::post('/add-status', [StatusController::class, 'postStatus']);
    Route::get('/fetch-status/{user_id}' , [StatusController::class, 'fetchStatus']);
    Route::patch('/update-status/{id}', [StatusController::class, 'updateStatus']);

    Route::post('/add-customer/{user_id}' , [CustomerController::class, 'getCustomerPostHistory']);

    Route::get('/fetch-history/{user_id}/{id}' , [HistoryController::class, 'fetchHistoryOfCustomer']);
    Route::get('/fetch-histories/{user_id}' , [HistoryController::class, 'fetchHistory']);
    Route::patch('/update-feedback/{user_id}', [FeedbackController::class, 'updateFeedback']);
    
});
Route::post('/reset-password' , [ForgotPasswordController::class, 'sendOTP']);
Route::get('/companies', [UserController::class, 'getCompaniesInfo']);
Route::get('/count/{machineId}/{id}', [BeanCounterController::class, 'fetchBeanCount']);

Route::post('/post-count', [BeanCounterController::class, 'postBeanCount']);
Route::post('/second-post-count', [BeanCounterController::class, 'secondPostBeanCount']);
Route::post('/insert-data' , [BeanCounterController::class, 'insertBadCount']);
Route::put('/user-edit/{id}', [ForgotPasswordController::class, 'passwrdEdit']);
Route::post('/verify-otp' , [ForgotPasswordController::class, 'verifyOTP']);
Route::post('/verify-key' , [UserController::class, 'verifyKey']);
Route::post('/post-feedback', [FeedbackController::class, 'postFeedback']);
Route::get('/fetch-feedback/{user_id}', [FeedbackController::class, 'fetchFeedback']);
