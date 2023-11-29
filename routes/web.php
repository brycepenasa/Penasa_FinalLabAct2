<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $users = DB::table('users')->select('name','email','created_at')->get();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});

Route::get('/all/categories', [CategoryController::class,'index'])->name('categories');
Route::get('/addCategory', [CategoryController::class, 'create'])->name('addCategory');
Route::post('/categories', [CategoryController::class, 'store'])->name('store-category');
Route::get('/editCategory/{category}', [CategoryController::class, 'edit'])->name('editCategory')->where('category', '.*');

Route::put('/updateCategory/{category}', [CategoryController::class, 'update'])->name('updateCategory')->where('category', '.*');
Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy'])->name('deleteCategory');
Route::post('/restoreCategory/{id}', [CategoryController::class, 'restore'])->name('restoreCategory');
