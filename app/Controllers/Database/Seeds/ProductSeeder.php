<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Kaos Santai Katun Premium',
                'slug'        => 'kaos-santai-katun-premium',
                'description' => 'Kaos super nyaman untuk dipakai sehari-hari, bahan katun combed 30s.',
                'price'       => '99000.00',
                'image_url'   => '[https://placehold.co/400x500/000000/FFFFFF?text=Kaos+Santai](https://placehold.co/400x500/000000/FFFFFF?text=Kaos+Santai)',
            ],
            [
                'name'        => 'Dress Pesta Elegan Midi',
                'slug'        => 'dress-pesta-elegan-midi',
                'description' => 'Tampil menawan di setiap acara dengan dress midi yang elegan dan modern.',
                'price'       => '245000.00',
                'image_url'   => '[https://placehold.co/400x500/ff6666/FFFFFF?text=Dress+Ayu](https://placehold.co/400x500/ff6666/FFFFFF?text=Dress+Ayu)',
            ],
            [
                'name'        => 'Kemeja Pria Lengan Panjang',
                'slug'        => 'kemeja-pria-lengan-panjang',
                'description' => 'Kemeja formal sekaligus kasual, cocok untuk kerja dan hangout.',
                'price'       => '189000.00',
                'image_url'   => '[https://placehold.co/400x500/3399ff/FFFFFF?text=Kemeja+Kerja](https://placehold.co/400x500/3399ff/FFFFFF?text=Kemeja+Kerja)',
            ],
            [
                'name'        => 'Outerwear Rajut Musim Dingin',
                'slug'        => 'outerwear-rajut-musim-dingin',
                'description' => 'Outerwear hangat dan stylish untuk melengkapi gayamu di musim hujan.',
                'price'       => '155000.00',
                'image_url'   => '[https://placehold.co/400x500/cccccc/000000?text=Outer+Gaya](https://placehold.co/400x500/cccccc/000000?text=Outer+Gaya)',
            ],
        ];

        // Using Query Builder
        $this->db->table('products')->insertBatch($data);
    }
}