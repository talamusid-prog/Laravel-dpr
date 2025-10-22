<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Rapat DPR-RI',
                'description' => 'Sidang paripurna DPR-RI membahas RUU penting',
                'image' => 'gallery/rapat-dpr.jpg',
                'image_path' => 'gallery/rapat-dpr.jpg',
                'category' => 'Politik',
                'is_active' => true,
            ],
            [
                'title' => 'Kunjungan Kerja',
                'description' => 'Kunjungan kerja ke Sulawesi Barat',
                'image' => 'gallery/kunjungan-kerja.jpg',
                'image_path' => 'gallery/kunjungan-kerja.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
            ],
            [
                'title' => 'Sosialisasi Program',
                'description' => 'Sosialisasi program pembangunan di masyarakat',
                'image' => 'gallery/sosialisasi.jpg',
                'image_path' => 'gallery/sosialisasi.jpg',
                'category' => 'Sosialisasi',
                'is_active' => true,
            ],
            [
                'title' => 'Rapat Komisi',
                'description' => 'Rapat komisi membahas anggaran daerah',
                'image' => 'gallery/rapat-komisi.jpg',
                'image_path' => 'gallery/rapat-komisi.jpg',
                'category' => 'Politik',
                'is_active' => true,
            ],
            [
                'title' => 'Penandatanganan MoU',
                'description' => 'Penandatanganan MoU dengan perguruan tinggi',
                'image' => 'gallery/mou.jpg',
                'image_path' => 'gallery/mou.jpg',
                'category' => 'Kerjasama',
                'is_active' => true,
            ],
            [
                'title' => 'Hari Kemerdekaan',
                'description' => 'Upacara peringatan hari kemerdekaan RI',
                'image' => 'gallery/17-agustus.jpg',
                'image_path' => 'gallery/17-agustus.jpg',
                'category' => 'Acara',
                'is_active' => true,
            ],
            [
                'title' => 'Rapat dengan Masyarakat',
                'description' => 'Rapat koordinasi dengan tokoh masyarakat',
                'image' => 'gallery/rapat-masyarakat.jpg',
                'image_path' => 'gallery/rapat-masyarakat.jpg',
                'category' => 'Masyarakat',
                'is_active' => true,
            ],
            [
                'title' => 'Kunjungan ke Sekolah',
                'description' => 'Kunjungan ke sekolah untuk program pendidikan',
                'image' => 'gallery/kunjungan-sekolah.jpg',
                'image_path' => 'gallery/kunjungan-sekolah.jpg',
                'category' => 'Pendidikan',
                'is_active' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}
