<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $produkData = [
            [
                'nama_produk' => 'Kompor Gas Portable',
                'gambar_produk' => 'kompor_gas.jpg',
                'kategori' => 'Peralatan Dapur',
                'deskripsi' => 'Kompor gas portable untuk memasak di mana saja.',
                'stok' => 5,
                'biaya_sewa' => 25000,
            ],
            [
                'nama_produk' => 'Blender Multifungsi',
                'gambar_produk' => 'blender.jpg',
                'kategori' => 'Peralatan Dapur',
                'deskripsi' => 'Blender untuk membuat jus dan menghaluskan bahan makanan.',
                'stok' => 3,
                'biaya_sewa' => 20000,
            ],

            [
                'nama_produk' => 'Vacuum Cleaner',
                'gambar_produk' => 'vacuum_cleaner.jpg',
                'kategori' => 'Peralatan Kebersihan',
                'deskripsi' => 'Penghisap debu untuk membersihkan rumah.',
                'stok' => 4,
                'biaya_sewa' => 30000,
            ],
            [
                'nama_produk' => 'Mesin Cuci Karpet',
                'gambar_produk' => 'mesin_cuci_karpet.jpg',
                'kategori' => 'Peralatan Kebersihan',
                'deskripsi' => 'Mesin untuk mencuci karpet dengan cepat.',
                'stok' => 2,
                'biaya_sewa' => 50000,
            ],

            [
                'nama_produk' => 'Palu Thor',
                'gambar_produk' => 'palu_thor.png',
                'kategori' => 'Perabotan',
                'deskripsi' => 'Ringan, mudah dibawa.',
                'stok' => 3,
                'biaya_sewa' => 1000000,
            ],
            [
                'nama_produk' => 'Kursi Lipat',
                'gambar_produk' => 'kursi_lipat.jpg',
                'kategori' => 'Perabotan',
                'deskripsi' => 'Kursi lipat untuk acara outdoor.',
                'stok' => 10,
                'biaya_sewa' => 15000,
            ],

            [
                'nama_produk' => 'Proyektor Mini',
                'gambar_produk' => 'proyektor_mini.jpg',
                'kategori' => 'Elektronik',
                'deskripsi' => 'Proyektor mini untuk presentasi atau hiburan.',
                'stok' => 3,
                'biaya_sewa' => 75000,
            ],
            [
                'nama_produk' => 'Speaker Bluetooth',
                'gambar_produk' => 'speaker_bluetooth.jpg',
                'kategori' => 'Elektronik',
                'deskripsi' => 'Speaker nirkabel dengan suara jernih.',
                'stok' => 5,
                'biaya_sewa' => 30000,
            ],

            [
                'nama_produk' => 'Lampu Hias LED',
                'gambar_produk' => 'lampu_hias.jpg',
                'kategori' => 'Dekorasi',
                'deskripsi' => 'Lampu hias untuk dekorasi ruangan.',
                'stok' => 8,
                'biaya_sewa' => 20000,
            ],
            [
                'nama_produk' => 'Bunga Dekorasi',
                'gambar_produk' => 'bunga_dekorasi.jpg',
                'kategori' => 'Dekorasi',
                'deskripsi' => 'Bunga dekorasi untuk acara spesial.',
                'stok' => 15,
                'biaya_sewa' => 10000,
            ],
        ];

        foreach ($produkData as $produk) {
            Produk::create($produk);
        }
    }
}
