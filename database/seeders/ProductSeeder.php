<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partner = User::where('role', 'partner')->first();
        $partnerId = $partner ? $partner->id : null;

        $products = [
            [
                'name' => 'Pupuk NPK Khusus Kelapa Sawit',
                'description' => 'Pupuk NPK berkualitas tinggi khusus untuk tanaman kelapa sawit. Meningkatkan produktivitas dan kesehatan tanaman.',
                'price' => 125000,
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=500',
                'stock' => 150,
                'category' => 'Pupuk',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Bibit Kelapa Sawit Unggul',
                'description' => 'Bibit kelapa sawit varietas unggul dengan tingkat produktivitas tinggi. Cocok untuk lahan baru maupun replanting.',
                'price' => 15000,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=500',
                'stock' => 500,
                'category' => 'Bibit',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Herbisida Sawit Premium',
                'description' => 'Herbisida efektif untuk mengendalikan gulma di perkebunan kelapa sawit. Ramah lingkungan dan mudah diaplikasikan.',
                'price' => 85000,
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=500',
                'stock' => 200,
                'category' => 'Pestisida',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Alat Panen Tandan Sawit',
                'description' => 'Alat panen ergonomis untuk memanen tandan buah segar. Terbuat dari bahan berkualitas tinggi dan tahan lama.',
                'price' => 350000,
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=500',
                'stock' => 50,
                'category' => 'Alat',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Pupuk Organik Kompos Sawit',
                'description' => 'Pupuk organik dari kompos kelapa sawit. Meningkatkan kesuburan tanah dan ramah lingkungan.',
                'price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=500',
                'stock' => 300,
                'category' => 'Pupuk',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Insektisida Sawit',
                'description' => 'Insektisida untuk mengendalikan hama pada tanaman kelapa sawit. Efektif dan aman digunakan.',
                'price' => 110000,
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=500',
                'stock' => 180,
                'category' => 'Pestisida',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Bibit Sawit DxP',
                'description' => 'Bibit kelapa sawit DxP dengan potensi hasil tinggi. Cocok untuk perkebunan komersial.',
                'price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=500',
                'stock' => 400,
                'category' => 'Bibit',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
            [
                'name' => 'Pupuk Urea Khusus Sawit',
                'description' => 'Pupuk urea berkualitas tinggi untuk pertumbuhan optimal tanaman kelapa sawit.',
                'price' => 105000,
                'image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=500',
                'stock' => 250,
                'category' => 'Pupuk',
                'partner_id' => $partnerId,
                'status' => 'approved',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
