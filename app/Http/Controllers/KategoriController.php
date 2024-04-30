<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\DataTables\KategoriDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
        //Filter data user berdasarkan kategori_id
        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }
        return DataTables::of($kategori)
            ->addIndexColumn()  //menambahkan kolom index/ no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function index(
    ) {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';  //set menu yang sedang aktiv
        $kategori = KategoriModel::all();     //ambil data untuk filter 
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'tambah kategori',
            'list' => ['Home', 'kategori', 'tambah']
        ];
        $page = (object) [
            'title' => 'tambah kategori baru'
        ];

        $kategori = KategoriModel::all();      //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori';//set menu yang sedang aktif
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }


    public function store(Request $request)
    {
        // $validated = $request->validate([

        //     'kategori_kode' => 'required',
        //     'kategori_nama' => 'required',
        // ]);
        $request->validate([

            'kategori_kode' => 'bail|required|unique:m_kategoris|max:255',
            'kategori_nama' => 'bail|required|max:255',

        ]);

        // Membuat data kategori baru
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        // Redirect ke halaman kategori setelah berhasil menyimpan
        return redirect('/kategori');
    }


    // $validateData = $request->validate([
    //     'title' => ['required', 'unique:posts', 'max:255'],
    //     'body' => ['required'],
    // ]);
    // $validateData = $request->validateWithBag('post', [
    //     'title' => ['required', 'unique:posts', 'max:255'],
    //     'body' => ['required'],
    // ]);


    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'

        ];

        $activeMenu = 'Kategori'; ///set menu yang aktif
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit user


    //Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            //kategori kode harus didisi, berupa string, minimal 3 karakter,
            //dan bernilai unik ditabel m_kategoris kolom kategori kecuali untuk katgeori dengan id yang sedang diedit
            'kategori_kode' => 'bail|required|max:255',
            'kategori_nama' => 'bail|required|unique:m_kategoris|max:255',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data berhasil diubah');
    }
    public function delete($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kategori',
            'list' => ['Home', 'kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori'; //set menu yangs edang aktif

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {      //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Data tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);    //Hapus data level

            return redirect('/kategori')->with('seccess', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkai dengan data ini');
        }
    }

}

// public function index()
// {

// $data = [
//     'kategori_kode' => 'SNK',
//     'kategori_nama' => 'Snack/Makanan ringan',
//     'created_at' => now()

// ];

// DB::table('m_kategoris')->insert($data);
// return 'insert data baru berhasil';


// $row = DB::table('m_kategoris')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'camilan']);
// return 'Update data berhasil. Jumlah data yang diupdate : ' . $row . 'baris';

// $row = DB::table('m_kategoris')->where('kategori_kode', 'SNK')->delete();
// return 'delete data berhasil. Jumlah data yang di delete : ' . $row . 'baris';



//----menampilkan data yang ada di table m_kategori-----

//         $data = DB::table('m_kategoris')->get();
//         return view('kategori', ['data' => $data]);


//     }
