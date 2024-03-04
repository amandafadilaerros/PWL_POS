<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'Yunila Putmasari',
                'penjualan_kode' => 'PJ001',
                'penjualan_tanggal' => '2024-01-21',
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'Amanda Fadila Erros',
                'penjualan_kode' => 'PJ002',
                'penjualan_tanggal' => '2024-01-023',
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Vunky Himawan',
                'penjualan_kode' => 'PJ003',
                'penjualan_tanggal' => '2024-01-24',
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Della Farahita',
                'penjualan_kode' => 'PJ004',
                'penjualan_tanggal' => '2024-01-26',
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Putra Zakaria',
                'penjualan_kode' => 'PJ005',
                'penjualan_tanggal' => '2024-01-29',
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Bagas Pratama',
                'penjualan_kode' => 'PJ006',
                'penjualan_tanggal' => '2024-02-03',
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Yolanda Saifaa',
                'penjualan_kode' => 'PJ007',
                'penjualan_tanggal' => '2024-02-05',
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Ahmad Saefudin',
                'penjualan_kode' => 'PJ008',
                'penjualan_tanggal' => '2024-02-11',
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Kayla Nada Nacita',
                'penjualan_kode' => 'PJ009',
                'penjualan_tanggal' =>'2024-02-15',
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Shaka Ehsan Revinza',
                'penjualan_kode' => 'PJ010',
                'penjualan_tanggal' => '2024-02-17',
            ],
        ];

        DB::table('t_penjualans')->insert($data);
    }
}