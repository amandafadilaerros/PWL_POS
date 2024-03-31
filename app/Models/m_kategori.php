<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class m_kategori extends Model
{
    use HasFactory;

    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'bail|required|unique:posts|max:255',
            'kategori_nama' => 'bail|required|max:255',
            'created_at' => 'bail|required',
            'updated_at' => 'bail|required',
        ]);

        // Lakukan proses penyimpanan data ke database

        // Redirect ke halaman '/kategori' setelah proses selesai
        return redirect('/kategori');
    }
}