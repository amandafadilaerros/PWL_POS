<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiPenjualanController;
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
    return view('welcome');
});


Route::get('level', [LevelController::class, 'index']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah'])->name('/user/tambah');
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan'])->name('/user/tambah_simpan');
Route::get('/user/ubah{id}', [UserController::class, 'ubah'])->name('/user/ubah');
Route::put('/user/ubah_simpan{id}', [UserController::class, 'ubah_simpan'])->name('/user/ubah_simpan');
Route::get('/user/hapus{id}', [UserController::class, 'hapus'])->name('/user/hapus');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store']);

Route::get('/kategori/create', [KategoriController::class, 'create'])->name('create');


Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/edit_simpan/{id}', [KategoriController::class, 'edit_simpan'])->name('kategori.edit_simpan');

Route::get('/kategori/hapus/{id}', [KategoriController::class, 'hapus'])->name('kategori.hapus');

Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);  // menampilkan halaman form tambah user 
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);  // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

//Fitur Level User
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);   //menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);         //menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']);       //menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  //menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data level
});

//Fitur Kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          //menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);       //menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);   //menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);          //menyimpan data kategori
    Route::get('/{id}', [KategoriController::class, 'show']);       //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  //menmapilkan halaman form esit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);     //menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);    //menghapus data kategori
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Barang
    Route::post('/list', [BarangController::class, 'list']); // menampilkan data Barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);  // menampilkan halaman form tambah Barang 
    Route::post('/', [BarangController::class, 'store']); // menyimpan data Barang baru
    Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Barang
    Route::put('/{id}', [BarangController::class, 'update']);  // menyimpan perubahan data Barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data user
});

//Fitur Stok
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal stok
    Route::post('/list', [StokController::class, 'list']); // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']);  // menampilkan halaman form tambah stok 
    Route::post('/', [StokController::class, 'store']); // menyimpan data stok baru
    Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail stok
    Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit stok
    Route::put('/{id}', [StokController::class, 'update']);  // menyimpan perubahan data stok
    Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [TransaksiPenjualanController::class, 'index']); // Menampilkan halaman awal Transaksi Penjualan
    Route::post('/list', [TransaksiPenjualanController::class, 'list']); // Menampilkan data Transaksi Penjualan dalam bentuk JSON untuk DataTables
    Route::get('/create', [TransaksiPenjualanController::class, 'create']); // Menampilkan halaman form tambah Transaksi Penjualan
    Route::post('/', [TransaksiPenjualanController::class, 'store']); // Menyimpan data Transaksi Penjualan baru
    Route::get('/{id}', [TransaksiPenjualanController::class, 'show']); // Menampilkan detail Transaksi Penjualan
    Route::get('/{id}/edit', [TransaksiPenjualanController::class, 'edit']); // Menampilkan halaman form edit Transaksi Penjualan
    Route::put('/{id}', [TransaksiPenjualanController::class, 'update']); // Menyimpan perubahan data Transaksi Penjualan
    Route::delete('/{id}', [TransaksiPenjualanController::class, 'destroy']); // Menghapus data Transaksi Penjualan
});
