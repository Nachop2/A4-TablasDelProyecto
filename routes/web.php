<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {

    //dd(opcache_get_status());

    return view('welcome');
});
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => 'true']);
Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);
Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('votes/{link}', [App\Http\Controllers\CommunityLinkUserController::class, 'store']);

Route::get('community/{channel:slug}', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::get('/profile/edit',[App\Http\Controllers\ProfileController::class, 'edit'])->middleware(['auth', 'verified']);
Route::post('/profile/store',[App\Http\Controllers\ProfileController::class, 'store']);

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/flash-message', function () {
    return view('flash-message');
});
