<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FakturController;
use App\Http\Controllers\PenawaranController;
use App\Http\Controllers\PenjualanController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

Route::resource('prospek', ProspekController::class)->middleware(['auth','sales', 'penjualan', 'pimpinan']);

Route::resource('pelanggan', PelangganController::class)->middleware(['auth','sales', 'penjualan', 'pimpinan']);

Route::resource('barang', BarangController::class)->middleware(['auth', 'penjualan']);

Route::resource('penjualan', PenjualanController::class)->middleware(['auth', 'pimpinan', 'marketing']);

Route::resource('penawaran', PenawaranController::class)->middleware(['auth', 'marketing']);

Route::get('coba', 'PenjualanController@print')->middleware(['auth', 'pimpinan', 'marketing']);


// logout
Route::get('/logout', function () {
    Auth::guard('web')->logout();
    return redirect('/');
})->name('logout');


require __DIR__.'/auth.php';
