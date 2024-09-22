<?php

use Illuminate\Support\Facades\Route;

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
//Public
Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('home.page');
Route::POST('/daftar', [App\Http\Controllers\PublicController::class, 'daftar'])->name('daftar.akun');
Route::get('/produk', [App\Http\Controllers\PublicController::class, 'produk'])->name('product.page');
Route::get('/produk/{id}', [App\Http\Controllers\PublicController::class, 'detail_produk']);

Route::POST('/set_password', [App\Http\Controllers\CustomAuth::class, 'set_password'])->name('set.password');
Route::POST('/validate', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');

Auth::routes();

//GET
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/data/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('admin.data.barang');
Route::get('/admin/data/gallery', [App\Http\Controllers\FotoController::class, 'index'])->name('admin.data.gallery');
Route::get('/admin/data/gallery/detail/{id}', [App\Http\Controllers\FotoController::class, 'detail']);
Route::get('/admin/data/kategori', [App\Http\Controllers\KategoriController::class, 'index'])->name('admin.data.kategori');
Route::get('/admin/penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('admin.penjualan');
Route::get('/admin/penjualan/tambah', [App\Http\Controllers\PenjualanController::class, 'tambah']);
Route::get('/admin/penjualan/edit/{id}', [App\Http\Controllers\PenjualanController::class, 'edit']);
Route::get('/admin/logs', [App\Http\Controllers\HistoryController::class, 'index'])->name('admin.logs');
Route::get('/admin/metode', [App\Http\Controllers\MetodeController::class, 'index'])->name('admin.metode');
Route::get('/admin/stok', [App\Http\Controllers\BarangMasukController::class, 'index'])->name('admin.stok');
Route::get('/admin/pengguna', [App\Http\Controllers\UsersController::class, 'index'])->name('admin.pengguna');
Route::get('/admin/supplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('admin.supplier');
Route::get('/admin/mutasi', [App\Http\Controllers\MutasiController::class, 'index'])->name('admin.mutasi');

//POST
Route::POST('/admin/data/barang/save', [App\Http\Controllers\BarangController::class, 'store']);
Route::POST('/admin/data/gallery/save', [App\Http\Controllers\FotoController::class, 'store']);
Route::POST('/admin/data/kategori/save', [App\Http\Controllers\KategoriController::class, 'store']);
Route::POST('/admin/penjualan/save', [App\Http\Controllers\PenjualanController::class, 'store']);
Route::POST('/admin/stok/save', [App\Http\Controllers\BarangMasukController::class, 'store']);
Route::POST('/admin/pengguna/save', [App\Http\Controllers\UsersController::class, 'store']);
Route::POST('/admin/supplier/save', [App\Http\Controllers\SupplierController::class, 'store']);

//PATCH
Route::POST('/admin/data/barang/update/{id}', [App\Http\Controllers\BarangController::class, 'update']);
Route::POST('/admin/data/gallery/update/{id}', [App\Http\Controllers\FotoController::class, 'update']);
Route::POST('/admin/data/gallery/detail/{od}/update/{id}', [App\Http\Controllers\FotoController::class, 'update_detail']);
Route::POST('/admin/data/kategori/update/{id}', [App\Http\Controllers\KategoriController::class, 'update']);
Route::POST('/admin/penjualan/update/{id}', [App\Http\Controllers\PenjualanController::class, 'update']);
Route::POST('/admin/stok/update/{id}', [App\Http\Controllers\BarangMasukController::class, 'update']);
Route::POST('/admin/pengguna/update/{id}', [App\Http\Controllers\UsersController::class, 'update']);
Route::POST('/admin/supplier/update/{id}', [App\Http\Controllers\SupplierController::class, 'update']);

//DESTROY
Route::GET('/admin/data/barang/delete/{id}', [App\Http\Controllers\BarangController::class, 'destroy']);
Route::GET('/admin/data/gallery/delete/{id}', [App\Http\Controllers\FotoController::class, 'destroy']);
Route::GET('/admin/data/gallery/detail/{od}/delete/{id}', [App\Http\Controllers\FotoController::class, 'destroy_detail']);
Route::GET('/admin/data/kategori/delete/{id}', [App\Http\Controllers\KategoriController::class, 'destroy']);
Route::GET('/admin/penjualan/delete/{id}', [App\Http\Controllers\PenjualanController::class, 'destroy']);
Route::GET('/admin/stok/delete/{id}', [App\Http\Controllers\BarangMasukController::class, 'destroy']);
Route::GET('/admin/pengguna/delete/{id}', [App\Http\Controllers\UsersController::class, 'destroy']);
Route::GET('/admin/supplier/delete/{id}', [App\Http\Controllers\SupplierController::class, 'destroy']);

//JSON
Route::get('/admin/data/barang/json', [App\Http\Controllers\BarangController::class, 'json']);
Route::get('/admin/data/gallery/json', [App\Http\Controllers\FotoController::class, 'json']);
Route::get('/admin/data/gallery/detail/{id}/json', [App\Http\Controllers\FotoController::class, 'json_detail']);
Route::get('/admin/data/kategori/json', [App\Http\Controllers\KategoriController::class, 'json']);
Route::get('/admin/history/json', [App\Http\Controllers\HistoryController::class, 'json']);
Route::get('/admin/metode/json/{id}', [App\Http\Controllers\MetodeController::class, 'pilih']);
Route::get('/admin/penjualan/json/', [App\Http\Controllers\PenjualanController::class, 'json']);
Route::get('/admin/penjualan/json/{id}', [App\Http\Controllers\PenjualanController::class, 'json']);
Route::get('/admin/stok/json', [App\Http\Controllers\BarangMasukController::class, 'json']);
Route::get('/admin/stok/json/{id}', [App\Http\Controllers\BarangMasukController::class, 'json']);
Route::get('/admin/pengguna/json', [App\Http\Controllers\UsersController::class, 'json']);
Route::get('/admin/supplier/json', [App\Http\Controllers\SupplierController::class, 'json']);
Route::get('/admin/mutasi/json/{id}', [App\Http\Controllers\MutasiController::class, 'json']);

//FIND
Route::get('/admin/data/barang/find/{id}', [App\Http\Controllers\BarangController::class, 'find']);
Route::get('/admin/data/barang/pilih/{id}', [App\Http\Controllers\BarangController::class, 'pilih']);
Route::get('/admin/data/gallery/find/{id}', [App\Http\Controllers\FotoController::class, 'find']);
Route::get('/admin/data/kategori/find/{id}', [App\Http\Controllers\KategoriController::class, 'find']);
Route::get('/admin/penjualan/find/{id}', [App\Http\Controllers\PenjualanController::class, 'find']);
Route::get('/admin/penjualan/pilih/{id}', [App\Http\Controllers\PenjualanController::class, 'pilih']);
Route::get('/admin/stok/find/{id}', [App\Http\Controllers\BarangMasukController::class, 'find']);
Route::get('/admin/pengguna/find/{id}', [App\Http\Controllers\UsersController::class, 'find']);
Route::get('/admin/supplier/find/{id}', [App\Http\Controllers\SupplierController::class, 'find']);

//PRINT
Route::POST('/admin/stok/print', [App\Http\Controllers\BarangMasukController::class, 'cetak']);
Route::POST('/admin/penjualan/print', [App\Http\Controllers\PenjualanController::class, 'cetak']);
Route::POST('/admin/metode/print', [App\Http\Controllers\MetodeController::class, 'cetak']);
Route::POST('/admin/mutasi/print', [App\Http\Controllers\MutasiController::class, 'cetak']);


//LOGIN PEGAWAI

//GET
Route::get('/pegawai/dashboard', [App\Http\Controllers\LoginPegawai::class, 'index'])->name('pegawai.dashboard');
Route::get('/pegawai/penjualan', [App\Http\Controllers\PegawaiPenjualanController::class, 'index'])->name('pegawai.penjualan');
Route::get('/pegawai/supplier', [App\Http\Controllers\PegawaiSupplierController::class, 'index'])->name('pegawai.supplier');
Route::get('/pegawai/stok', [App\Http\Controllers\PegawaiBarangMasukController::class, 'index'])->name('pegawai.stok');
Route::get('/pegawai/pengguna', [App\Http\Controllers\ProfileController::class, 'index'])->name('pegawai.pengguna');
Route::get('/pegawai/mutasi', [App\Http\Controllers\PegawaiMutasiController::class, 'index'])->name('pegawai.mutasi');

Route::get('/pegawai/penjualan/tambah', [App\Http\Controllers\PegawaiPenjualanController::class, 'tambah']);
Route::get('/pegawai/penjualan/edit/{id}', [App\Http\Controllers\PegawaiPenjualanController::class, 'edit']);
//POST
Route::POST('/pegawai/stok/save', [App\Http\Controllers\PegawaiBarangMasukController::class, 'store']);
Route::POST('/pegawai/pengguna/save', [App\Http\Controllers\ProfileController::class, 'store']);
Route::POST('/pegawai/penjualan/save', [App\Http\Controllers\PegawaiPenjualanController::class, 'store']);

//PATCH
Route::POST('/pegawai/stok/update/{id}', [App\Http\Controllers\PegawaiBarangMasukController::class, 'update']);
Route::POST('/pegawai/pengguna/update', [App\Http\Controllers\ProfileController::class, 'update']);
Route::POST('/pegawai/penjualan/update/{id}', [App\Http\Controllers\PegawaiPenjualanController::class, 'update']);

//DESTROY

Route::GET('/pegawai/stok/delete/{id}', [App\Http\Controllers\PegawaiBarangMasukController::class, 'destroy']);

//JSON
Route::get('/pegawai/data/barang/json', [App\Http\Controllers\PegawaiBarangMasukController::class, 'json_barang']);
Route::get('/pegawai/supplier/json', [App\Http\Controllers\PegawaiBarangMasukController::class, 'json_supplier']);
Route::get('/pegawai/penjualan/json', [App\Http\Controllers\PegawaiPenjualanController::class, 'json']);
Route::get('/pegawai/penjualan/json/{id}', [App\Http\Controllers\PegawaiPenjualanController::class, 'json']);
Route::get('/pegawai/stok/json', [App\Http\Controllers\PegawaiBarangMasukController::class, 'json']);
Route::get('/pegawai/stok/json/{id}', [App\Http\Controllers\PegawaiBarangMasukController::class, 'json']);
Route::get('/pegawai/data/barang/pilih/{id}', [App\Http\Controllers\PegawaiBarangMasukController::class, 'pilih']);
Route::get('/pegawai/mutasi/json/{id}', [App\Http\Controllers\PegawaiMutasiController::class, 'json']);

//FIND
Route::get('/pegawai/stok/find/{id}', [App\Http\Controllers\PegawaiBarangMasukController::class, 'find']);
Route::get('/pegawai/penjualan/pilih/{id}', [App\Http\Controllers\PegawaiPenjualanController::class, 'pilih']);

//PRINT
Route::POST('/pegawai/stok/print', [App\Http\Controllers\PegawaiBarangMasukController::class, 'cetak']);
Route::POST('/pegawai/penjualan/print', [App\Http\Controllers\PegawaiPenjualanController::class, 'cetak']);
Route::POST('/pegawai/mutasi/print', [App\Http\Controllers\PegawaiMutasiController::class, 'cetak']);

//Robot
Route::get('/robot/notif/json/{id}', [App\Http\Controllers\NotifLoader::class, 'read']);
Route::get('/robot/notif/get', [App\Http\Controllers\NotifLoader::class, 'get_notif']);
Route::get('/robot/notif/test', [App\Http\Controllers\NotifLoader::class, 'test']);
