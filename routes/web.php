<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('channels', 'App\Http\Controllers\ChannelController');

Route::middleware(['auth'])->group(function(){
    Route::get('channels/{channel}/videos', 'App\Http\Controllers\UploadVideoController@index')->name('channel.upload');
    Route::resource('channels/{channel}/subscriptions', 'App\Http\Controllers\SubscriptionController')->only(['store', 'destroy']);
    Route::post('channels/{channel}/videos', 'App\Http\Controllers\UploadVideoController@store');
});

Route::get('videos/{video}', 'App\Http\Controllers\VideoController@show');
