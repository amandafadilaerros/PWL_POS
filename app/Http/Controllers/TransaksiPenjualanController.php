<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\TransaksiPenjualanModel;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\DetailTransaksiPenjualanModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar transaksi penjualan yang terdaftar dalam sistem'
        ];
        $activeMenu = 'penjualan'; // set menu yang sedang aktif

        $user = UserModel::all();     //ambil data level untuk filter level
        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Ambil data barang dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $penjualans = TransaksiPenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user');

        //Filter data barang berdasarkan level_id
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }
        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah transaksi penjualan baru'
        ];
        $user = UserModel::all(); //ambil data user untuk ditampilkan di form
        $barang = BarangModel::all(); //ambil data user untuk ditampilkan di form
        $activeMenu = 'penjualan'; // set menu yang sedang aktif
        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Ubah format tanggal sebelum proses validasi
        $request->merge([
            'penjualan_tanggal' => Carbon::createFromFormat('Y-m-d\TH:i', $request->penjualan_tanggal)->format('Y-m-d H:i:s')
        ]);

        // Validasi data
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualans,penjualan_kode',
            'penjualan_tanggal' => 'required|date_format:Y-m-d H:i:s',
            'barang_id' => 'required|integer',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer'
        ]);

        // Proses penyimpanan data dan lainnya...
        // Simpan data transaksi penjualan
        $transaksiPenjualan = TransaksiPenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        // Dapatkan penjualan_id setelah menyimpan data transaksi penjualan baru
        $penjualanId = $transaksiPenjualan->penjualan_id;

        // Simpan detail transaksi penjualan dengan menggunakan penjualan_id yang didapatkan sebelumnya
        DetailTransaksiPenjualanModel::create([
            'penjualan_id' => $penjualanId,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }


    public function show(String $id)
    {
        $penjualan = TransaksiPenjualanModel::find($id);
        $detailTransaksi = DetailTransaksiPenjualanModel::where('penjualan_id', $id)->get();

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi Penjualan',
            'list'  => ['Home', 'Transaksi Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.show', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'penjualan' => $penjualan,
            'detailTransaksi' => $detailTransaksi,
            'activeMenu' => $activeMenu
        ]);
    }


    public function edit($id)
    {
        $penjualan = TransaksiPenjualanModel::find($id);
        $detailPenjualan = DetailTransaksiPenjualanModel::where('penjualan_id', $id)->first();
        $user = UserModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Transaksi Penjualan',
            'list'  => ['Home', 'Transaksi Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan, //ubah detail menjadi detailPenjualan
            'user' => $user,
            'barang' => $barang,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:255',
            'penjualan_kode' => 'required|string|max:255|unique:t_penjualans,penjualan_kode,' . $id . ',penjualan_id',
            'penjualan_tanggal' => 'required|date_format:Y-m-d\TH:i',
            'barang_id' => 'required|integer',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer'
        ]);

        $penjualan = TransaksiPenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        $penjualan->user_id = $request->user_id;
        $penjualan->pembeli = $request->pembeli;
        $penjualan->penjualan_kode = $request->penjualan_kode;
        $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
        $penjualan->save();

        // Simpan detail transaksi penjualan
        $detailPenjualan = DetailTransaksiPenjualanModel::where('penjualan_id', $id)->first(); // Menggunakan first() untuk mendapatkan objek tunggal
        $detailPenjualan->barang_id = $request->barang_id;
        $detailPenjualan->harga = $request->harga;
        $detailPenjualan->jumlah = $request->jumlah;
        $detailPenjualan->save();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $penjualan = TransaksiPenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            DetailTransaksiPenjualanModel::where('penjualan_id', $id)->delete();

            $penjualan->delete();

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Exception $e) {
            //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkai dengan data ini');
        }
    }
}
