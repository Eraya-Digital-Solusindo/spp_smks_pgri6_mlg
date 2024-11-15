<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{BerandaController, HakaksesController, AuthController, MasterDataController, SppController};
use Illuminate\Http\Request;

Route::get('generate-csrf-token', function () { $token = csrf_token(); return response()->json(['csrf_token' => $token]); });
Route::get('/', function (Request $req) { $data = [ 'tipe_halaman' => 'login']; return view('login', ['data' => $data]); })->name('login');
Route::get('403', function () { return view('error.403_error'); });
Route::group(['middleware' => ['jwt.cookie']], function () {
    Route::get('pintukeluar', [AuthController::class, "logout"]);
    Route::prefix('admin')->group(function () {
        Route::get('beranda', [BerandaController::class,"index"])->name('admin.beranda');
        Route::get('pengguna_aplikasi', [HakaksesController::class,"pengguna_aplikasi"])->name('admin.pengguna_aplikasi');
        Route::get('permission', [HakaksesController::class,"permission"])->name('admin.permission');
        Route::get('role', [HakaksesController::class,"role"])->name('admin.role');
    });
    Route::prefix('admin')->group(function () {
        Route::get('beranda', [BerandaController::class,"index"])->name('admin.beranda');
        Route::get('pengguna_aplikasi', [HakaksesController::class,"pengguna_aplikasi"])->name('admin.pengguna_aplikasi');
        Route::get('permission', [HakaksesController::class,"permission"])->name('admin.permission');
        Route::get('role', [HakaksesController::class,"role"])->name('admin.role');
    });
    Route::prefix('masterdata')->group(function () {
        Route::get('daftar_jurusan_siswa', [MasterDataController::class,"daftar_jurusan_siswa"])->name('admin.daftar_jurusan_siswa');
        Route::get('daftar_kelas_siswa', [MasterDataController::class,"daftar_kelas_siswa"])->name('admin.daftar_kelas_siswa');
        Route::get('daftar_jenis_pembayaran', [MasterDataController::class,"daftar_jenis_pembayaran"])->name('admin.daftar_jenis_pembayaran');
    });
    Route::prefix('spp')->group(function () {
        Route::get('daftar_pembayaran', [SppController::class,"daftar_pembayaran"])->name('spp.daftar_pembayaran');
        Route::get('transaksi_pembayaran/{id_transaksi?}', [SppController::class,"transaksi_pembayaran"])->name('spp.transaksi_pembayaran');
        Route::get('daftar_tagihan', [SppController::class,"daftar_tagihan"])->name('spp.daftar_tagihan');
        Route::get('form_tagihan', [SppController::class,"form_tagihan"])->name('spp.form_tagihan');
        Route::get('cetak_bukti_pembayaran/{id_transaksi}', [SppController::class,"cetakbuktipembayaran"])->name('spp.cetak_bukti_pembayaran');
    });
});
