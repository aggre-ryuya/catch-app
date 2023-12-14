<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;

Route::get('userList',[UserController::class, 'index'])->middleware(['auth', 'verified'])->name('userList');
Route::get('userPay/getUser/{id}',[UserController::class, 'getUser'])->middleware(['auth', 'verified']);    
Route::get('userPay/getUserSale/{id}',[UserController::class, 'getUserSale'])->middleware(['auth', 'verified']);    

Route::post('userPay/userSaleCreate/',[UserController::class, 'userpaystore'])->middleware(['auth', 'verified'])->name('paystore');
Route::post('userPay/userSaleUpdate/',[UserController::class, 'userpayupdate'])->middleware(['auth', 'verified'])->name('paystore');

Route::resource('users',UserController::class)->middleware(['auth', 'verified']);


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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
