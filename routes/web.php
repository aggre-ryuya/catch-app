<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;

Route::get('userList',[UserController::class, 'index'])->middleware(['auth', 'verified'])->name('UserLists');   

Route::get('user/userShow/{userId}',[UserController::class, 'show'])->middleware(['auth', 'verified'])->name('user.show');
Route::get('user/userCreate',[UserController::class, 'create'])->middleware(['auth', 'verified'])->name('user.Create');
Route::get('user/salePayList/{id}',[UserController::class, 'getSalePayList'])->middleware(['auth', 'verified'])->name('userPayList');    
Route::get('user/userSalePay/{id}',[UserController::class, 'getUserSale'])->middleware(['auth', 'verified'])->name('userSalePay');    

Route::post('user/storePay/',[UserController::class, 'userPayStore'])->middleware(['auth', 'verified'])->name('storePay');
Route::post('user/userStore',[UserController::class, 'store'])->middleware(['auth', 'verified']);

Route::post('userPay/userSaleUpdate/',[UserController::class, 'userpayupdate'])->middleware(['auth', 'verified'])->name('paystore');
// Route::post('userPay/userStore/',[UserController::class, 'store'])->middleware(['auth', 'verified'])->name('userStore');

// Route::resource('users',UserController::class)->middleware(['auth', 'verified']);


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
