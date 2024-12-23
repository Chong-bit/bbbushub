<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Usercontroller;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\AdminMiddleware;
use App\Http\Controllers\UserMiddleware;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryBusController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','userMiddleware'])->group(function(){
 Route::get('dashboard',[Usercontroller::class,'index'])->name('dashboard');
 Route::get('report',[Usercontroller::class,'report'])->name('report');
 Route::get('route',[Usercontroller::class,'route'])->name('route');
});

Route::middleware(['auth','adminMiddleware'])->group(function(){
    Route::get('/admin/dashboard',[Admincontroller::class,'index'])->name('admin.dashboard');
    Route::get('/admin/location',[Admincontroller::class,'location'])->name('admin.location');
    Route::get('/admin/route',[Admincontroller::class,'route'])->name('admin.route');
    Route::get('/admin/status',[Admincontroller::class,'status'])->name('admin.status');

   });

   Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/bus', [CategoryBusController::class, 'index'])->name('admin.bus'); // List buses
    Route::post('/admin/bus', [CategoryBusController::class, 'store'])->name('admin.store'); // Add a new bus
    Route::put('/admin/bus/{id}', [CategoryBusController::class, 'update'])->name('admin.update'); // Update a bus
    Route::delete('/admin/bus/{id}', [CategoryBusController::class, 'destroy'])->name('admin.destroy'); // Delete a bus
});

