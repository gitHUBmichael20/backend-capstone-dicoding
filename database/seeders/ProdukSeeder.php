<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $categories = [
            'Sofa',
            'Meja',
            'Kursi',
            'Lemari',
            'Rak',
            'Kompor',
            'Microwave',
            'Blender',
            'Lampu Hias',
            'Karpet'
        ];

        for ($i = 0; $i < 20; $i++) {
            $category = $categories[$i % count($categories)];
            $productName = $this->generateProductName($category, $faker);
            $description = $this->generateProductDescription($category, $faker);
            $image = $this->generateProductImage($category, $i);

            DB::table('produk')->insert([
                'nama_produk' => $productName,
                'kategori' => $category,
                'deskripsi' => $description,
                'stok' => $faker->numberBetween(5, 50),
                'biaya_sewa' => $faker->numberBetween(50000, 1000000),
                'gambar_produk' => $image,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now()
            ]);
        }
    }

    private function generateProductName($category, $faker)
    {
        $brands = [
            'Sofa' => ['IKEA', 'Informa', 'Olympic'],
            'Meja' => ['IKEA', 'Livien', 'Dekoruma'],
            'Kursi' => ['Informa', 'Olympic', 'Ace Hardware'],
            'Lemari' => ['IKEA', 'Olympic', 'Livien'],
            'Rak' => ['IKEA', 'Ace Hardware', 'Ruparupa'],
            'Kompor' => ['Maspion', 'Miyako', 'Philips'],
            'Microwave' => ['Philips', 'Oxone', 'Samsung'],
            'Blender' => ['Maspion', 'Philips', 'Miyako'],
            'Lampu Hias' => ['Ace Hardware', 'Dekoruma', 'Ruparupa'],
            'Karpet' => ['IKEA', 'Ace Hardware', 'Informa']
        ];

        $brand = $faker->randomElement($brands[$category]);
        $model = $faker->numberBetween(10000, 99999);

        return "$brand $category $model";
    }

    private function generateProductDescription($category, $faker)
    {
        $features = [
            'Sofa' => ['kulit asli', 'busa empuk', 'desain modern'],
            'Meja' => ['kayu solid', 'anti gores', 'mudah dirakit'],
            'Kursi' => ['ergonomis', 'kokoh', 'ringan'],
            'Lemari' => ['pintu geser', 'banyak rak', 'tahan lama'],
            'Rak' => ['fleksibel', 'mudah dipasang', 'minimalis'],
            'Kompor' => ['api biru', 'hemat gas', 'stainless steel'],
            'Microwave' => ['pemanas cepat', 'kapasitas besar', 'mudah dibersihkan'],
            'Blender' => ['pisau tajam', 'tenaga kuat', 'desain praktis'],
            'Lampu Hias' => ['hemat energi', 'cahaya warm', 'desain elegan'],
            'Karpet' => ['lembut', 'anti slip', 'mudah dibersihkan']
        ];

        $uses = [
            'Sofa' => ['ruang tamu', 'ruang keluarga', 'kantor'],
            'Meja' => ['makan', 'belajar', 'kerja'],
            'Kursi' => ['ruang makan', 'kantor', 'teras'],
            'Lemari' => ['pakaian', 'dokumen', 'peralatan'],
            'Rak' => ['buku', 'dekorasi', 'dapur'],
            'Kompor' => ['memasak', 'menggoreng', 'merebus'],
            'Microwave' => ['memanaskan', 'mencairkan', 'memanggang'],
            'Blender' => ['jus', 'smoothie', 'bumbu'],
            'Lampu Hias' => ['dekorasi ruangan', 'pencahayaan ambient', 'lampu tidur'],
            'Karpet' => ['ruang tamu', 'kamar tidur', 'ruang bermain']
        ];

        $featureList = implode(', ', $faker->randomElements($features[$category], 3));
        $useList = implode(', ', $faker->randomElements($uses[$category], 2));

        return "Produk $category berkualitas dengan $featureList. Cocok untuk $useList. " .
            "Desain praktis dan tahan lama untuk kebutuhan rumah tangga.";
    }

    private function generateProductImage($category, $index)
    {
        // Base URL for Lorem Picsum
        $baseUrl = 'https://picsum.photos/id/';

        // Assign specific image IDs based on category for variety
        $imageIds = [
            'Sofa' => [110, 111, 112, 113, 114],
            'Meja' => [120, 121, 122, 123, 124],
            'Kursi' => [130, 131, 132, 133, 134],
            'Lemari' => [140, 141, 142, 143, 144],
            'Rak' => [150, 151, 152, 153, 154],
            'Kompor' => [160, 161, 162, 163, 164],
            'Microwave' => [170, 171, 172, 173, 174],
            'Blender' => [180, 181, 182, 183, 184],
            'Lampu Hias' => [190, 191, 192, 193, 194],
            'Karpet' => [200, 201, 202, 203, 204]
        ];

        // Pick an image ID from the category's range based on index
        $idIndex = $index % 5; // Cycle through 5 images per category
        $imageId = $imageIds[$category][$idIndex];

        // Return URL with 500x300 resolution
        return "{$baseUrl}{$imageId}/1920/1080";
    }
}
