<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BowoController;

Route::get('/',[BowoController::class,'home'])->name('home');
Route::get('/leaderboard',[BowoController::class,'leaderboard'])->name('leaderboard');
Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'loginForm'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.process');
    Route::get('/register',[AuthController::class,'registerForm'])->name('register');
    Route::post('/register',[AuthController::class,'register'])->name('register.process');
});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth','role:nasabah'])->prefix('user')->name('user.')->group(function(){
    Route::get('/dashboard',[BowoController::class,'userDashboard'])->name('dashboard');
    Route::get('/setor',[BowoController::class,'setorForm'])->name('setor');
    Route::post('/setor',[BowoController::class,'setor'])->name('setor.store');
    Route::get('/riwayat',[BowoController::class,'riwayat'])->name('riwayat');
});
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard',[BowoController::class,'adminDashboard'])->name('dashboard');
    Route::post('/verifikasi/{deposit}',[BowoController::class,'verify'])->name('verify');
    Route::get('/jenis-sampah',[BowoController::class,'wastes'])->name('wastes');
    Route::post('/jenis-sampah',[BowoController::class,'saveWaste'])->name('wastes.store');
    Route::post('/jenis-sampah/{wasteType}/nonaktif',[BowoController::class,'deleteWaste'])->name('wastes.delete');
    Route::get('/laporan',[BowoController::class,'reports'])->name('reports');
});
