<?php

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('channels', 'App\Http\Controllers\ChannelController');

// Route::get('videos/{video}', 'App\Http\Controllers\VideoController@show')
Route::put('videos/{video}', 'App\Http\Controllers\VideoController@updateViews');
Route::get('videos/{video}/comments', 'App\Http\Controllers\CommentController@index');
Route::post('comments/{video}/comment', 'App\Http\Controllers\CommentController@store')->name('comment.store');
Route::get('comments/{comment}/replies', 'App\Http\Controllers\CommentController@show');
Route::put('videos/{video}/update', 'App\Http\Controllers\VideoController@update')->middleware(['auth'])->name('videos.update');
Route::get('user/{user}', 'App\Http\Controllers\HomeController@GetUserInfo');


Route::middleware(['auth'])->group(function(){
    Route::post('comments/{video}', 'App\Http\Controllers\CommentController@store');
    Route::post('votes/{entityId}/{type}', 'App\Http\Controllers\VoteController@vote');
    Route::get('channels/{channel}/videos', 'App\Http\Controllers\UploadVideoController@index')->name('channel.upload');
    Route::resource('channels/{channel}/subscriptions', 'App\Http\Controllers\SubscriptionController')->only(['store', 'destroy']);
    Route::post('channels/{channel}/videos', 'App\Http\Controllers\UploadVideoController@store');
});

Route::get('videos/{video}', 'App\Http\Controllers\VideoController@show')->name('videos.show');
