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
            'Perabotan',        // Sofa, Meja, Kursi, Lemari, Rak, Karpet
            'Peralatan Dapur',  // Kompor, Microwave, Blender
            'Dekorasi',         // Lampu Hias
            'Peralatan Kebersihan', // New: e.g., Sapu, Pel
            'Elektronik'        // New: e.g., TV, Speaker
        ];

        for ($i = 0; $i < 25; $i++) {
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
            'Perabotan' => ['IKEA', 'Informa', 'Olympic', 'Livien', 'Dekoruma'],
            'Peralatan Dapur' => ['Maspion', 'Miyako', 'Philips', 'Oxone', 'Samsung'],
            'Dekorasi' => ['Ace Hardware', 'Dekoruma', 'Ruparupa'],
            'Peralatan Kebersihan' => ['Krisbow', 'Lion Star', 'Ace Hardware'],
            'Elektronik' => ['Samsung', 'LG', 'Sony', 'Philips']
        ];

        $brand = $faker->randomElement($brands[$category]);
        $model = $faker->numberBetween(10000, 99999);

        // Adjust the name format to be more specific to the category
        $specificType = [
            'Perabotan' => ['Sofa', 'Meja', 'Kursi', 'Lemari', 'Rak', 'Karpet'],
            'Peralatan Dapur' => ['Kompor', 'Microwave', 'Blender'],
            'Dekorasi' => ['Lampu Hias', 'Hiasan Dinding'],
            'Peralatan Kebersihan' => ['Sapu', 'Pel', 'Ember'],
            'Elektronik' => ['TV', 'Speaker', 'Kipas Angin']
        ];

        $type = $faker->randomElement($specificType[$category]);
        return "$brand $type $model";
    }

    private function generateProductDescription($category, $faker)
    {
        $features = [
            'Perabotan' => ['kokoh', 'desain modern', 'mudah dirakit', 'tahan lama', 'minimalis'],
            'Peralatan Dapur' => ['hemat energi', 'mudah dibersihkan', 'stainless steel', 'kapasitas besar', 'desain praktis'],
            'Dekorasi' => ['hemat energi', 'cahaya warm', 'desain elegan', 'estetis', 'mudah dipasang'],
            'Peralatan Kebersihan' => ['ergonomis', 'tahan lama', 'mudah digunakan', 'ringan', 'efisien'],
            'Elektronik' => ['teknologi canggih', 'hemat listrik', 'kualitas suara jernih', 'layar tajam', 'desain modern']
        ];

        $uses = [
            'Perabotan' => ['ruang tamu', 'ruang makan', 'kamar tidur', 'kantor', 'teras'],
            'Peralatan Dapur' => ['memasak', 'menggoreng', 'memanaskan', 'mencairkan', 'membuat jus'],
            'Dekorasi' => ['dekorasi ruangan', 'pencahayaan ambient', 'hiasan dinding', 'lampu tidur'],
            'Peralatan Kebersihan' => ['membersihkan lantai', 'menyapu halaman', 'mencuci peralatan'],
            'Elektronik' => ['hiburan rumah', 'pendingin ruangan', 'presentasi kantor']
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
            'Perabotan' => [110, 111, 112, 113, 114],
            'Peralatan Dapur' => [160, 161, 162, 163, 164],
            'Dekorasi' => [190, 191, 192, 193, 194],
            'Peralatan Kebersihan' => [210, 211, 212, 213, 214],
            'Elektronik' => [220, 221, 222, 223, 224]
        ];

        // Pick an image ID from the category's range based on index
        $idIndex = $index % 5; // Cycle through 5 images per category
        $imageId = $imageIds[$category][$idIndex];

        // Return URL with 1920x1080 resolution
        return "{$baseUrl}{$imageId}/1920/1080";
    }
}
