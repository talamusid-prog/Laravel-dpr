<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Kunjungan Kerja ke Kabupaten Mamuju Tengah',
                'excerpt' => 'Melakukan kunjungan kerja untuk meninjau pembangunan infrastruktur dan mendengarkan aspirasi masyarakat di Kabupaten Mamuju Tengah.',
                'content' => '<h2>Latar Belakang</h2>
<p>Kunjungan kerja ini dilakukan dalam rangka meninjau pembangunan infrastruktur yang sedang berlangsung di Kabupaten Mamuju Tengah. Sebagai anggota DPR-RI dari Dapil Sulawesi Barat, saya merasa penting untuk melakukan monitoring langsung terhadap program-program pembangunan yang telah dianggarkan.</p>

<h2>Kegiatan yang Dilakukan</h2>
<p>Selama kunjungan kerja, beberapa kegiatan yang dilakukan antara lain:</p>
<ul>
<li>Meninjau proyek pembangunan jalan raya yang menghubungkan Mamuju Tengah dengan kabupaten lain</li>
<li>Mengunjungi sekolah-sekolah untuk melihat kondisi sarana dan prasarana pendidikan</li>
<li>Bertemu dengan masyarakat untuk mendengarkan aspirasi dan keluhan mereka</li>
<li>Koordinasi dengan pemerintah daerah terkait program pembangunan</li>
</ul>

<h2>Hasil Kunjungan</h2>
<p>Dari kunjungan kerja ini, diperoleh beberapa temuan penting:</p>
<ol>
<li>Proyek pembangunan jalan raya berjalan sesuai jadwal</li>
<li>Beberapa sekolah membutuhkan perbaikan sarana dan prasarana</li>
<li>Masyarakat mengeluhkan akses air bersih yang masih terbatas</li>
<li>Perlu peningkatan program pemberdayaan ekonomi masyarakat</li>
</ol>

<h2>Komitmen ke Depan</h2>
<p>Berdasarkan temuan dari kunjungan kerja ini, saya berkomitmen untuk:</p>
<ul>
<li>Mengalokasikan anggaran tambahan untuk perbaikan sarana pendidikan</li>
<li>Mendorong program penyediaan air bersih untuk masyarakat</li>
<li>Mengembangkan program pemberdayaan ekonomi masyarakat</li>
<li>Melakukan monitoring berkala terhadap program pembangunan</li>
</ul>',
                'slug' => 'kunjungan-kerja-mamuju-tengah',
                'category' => 'Kegiatan',
                'tags' => ['Kunjungan', 'Infrastruktur', 'Mamuju Tengah'],
                'published_at' => now()->subDays(5),
                'views' => 1250,
                'status' => 'published',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Rapat Koordinasi dengan Dinas Pendidikan',
                'excerpt' => 'Membahas program peningkatan kualitas pendidikan dan pemberian beasiswa untuk siswa berprestasi di Sulawesi Barat.',
                'content' => '<h2>Agenda Rapat</h2>
<p>Rapat koordinasi ini membahas beberapa program strategis di bidang pendidikan yang akan dilaksanakan di Sulawesi Barat pada tahun 2024.</p>

<h2>Program yang Dibahas</h2>
<ul>
<li>Program beasiswa untuk siswa berprestasi</li>
<li>Peningkatan kualitas guru melalui pelatihan</li>
<li>Pembangunan sarana dan prasarana pendidikan</li>
<li>Program literasi digital untuk siswa</li>
</ul>

<h2>Komitmen Anggaran</h2>
<p>Untuk mendukung program-program tersebut, telah dialokasikan anggaran sebesar Rp 2 miliar yang akan digunakan untuk:</p>
<ol>
<li>Beasiswa siswa berprestasi: Rp 500 juta</li>
<li>Pelatihan guru: Rp 300 juta</li>
<li>Pembangunan sarana pendidikan: Rp 1 miliar</li>
<li>Program literasi digital: Rp 200 juta</li>
</ol>',
                'slug' => 'rapat-koordinasi-dinas-pendidikan',
                'category' => 'Pendidikan',
                'tags' => ['Pendidikan', 'Beasiswa', 'Siswa Berprestasi'],
                'published_at' => now()->subDays(8),
                'views' => 980,
                'status' => 'published',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'title' => 'Sosialisasi Program Bantuan UMKM',
                'excerpt' => 'Menyelenggarakan sosialisasi program bantuan untuk Usaha Mikro, Kecil dan Menengah (UMKM) di wilayah Sulawesi Barat.',
                'content' => '<h2>Program Bantuan UMKM</h2>
<p>Program ini bertujuan untuk memberdayakan UMKM di Sulawesi Barat melalui berbagai bentuk bantuan dan pelatihan.</p>

<h2>Jenis Bantuan</h2>
<ul>
<li>Bantuan modal usaha</li>
<li>Pelatihan kewirausahaan</li>
<li>Bantuan pemasaran digital</li>
<li>Pendampingan bisnis</li>
</ul>

<h2>Target Penerima</h2>
<p>Program ini menargetkan 500 UMKM di Sulawesi Barat dengan prioritas:</p>
<ol>
<li>UMKM yang terdampak pandemi</li>
<li>UMKM yang dikelola oleh perempuan</li>
<li>UMKM di daerah terpencil</li>
<li>UMKM dengan produk unggulan daerah</li>
</ol>',
                'slug' => 'sosialisasi-program-bantuan-umkm',
                'category' => 'Ekonomi',
                'tags' => ['UMKM', 'Bantuan', 'Ekonomi'],
                'published_at' => now()->subDays(10),
                'views' => 1560,
                'status' => 'published',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Pertemuan dengan Komisi X DPR-RI',
                'excerpt' => 'Mengikuti pertemuan komisi untuk membahas RUU tentang Pendidikan dan Kebudayaan di Gedung DPR-RI.',
                'content' => '<h2>Agenda Pertemuan</h2>
<p>Pertemuan ini membahas Rancangan Undang-Undang (RUU) tentang Pendidikan dan Kebudayaan yang sedang dalam proses pembahasan di DPR-RI.</p>

<h2>Poin-Poin Penting</h2>
<ul>
<li>Peningkatan anggaran pendidikan</li>
<li>Reformasi sistem pendidikan nasional</li>
<li>Peningkatan kualitas guru</li>
<li>Pengembangan kurikulum yang relevan</li>
</ul>

<h2>Komitmen Dukungan</h2>
<p>Sebagai anggota DPR-RI, saya berkomitmen untuk mendukung RUU ini dengan memastikan:</p>
<ol>
<li>Anggaran pendidikan minimal 20% dari APBN</li>
<li>Peningkatan kesejahteraan guru</li>
<li>Pemerataan akses pendidikan</li>
<li>Penguatan pendidikan karakter</li>
</ol>',
                'slug' => 'pertemuan-komisi-x-dpr-ri',
                'category' => 'Legislasi',
                'tags' => ['DPR-RI', 'Komisi X', 'RUU'],
                'published_at' => now()->subDays(12),
                'views' => 2100,
                'status' => 'published',
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            [
                'title' => 'Kunjungan ke Sekolah Dasar Terpencil',
                'excerpt' => 'Mengunjungi sekolah dasar di daerah terpencil untuk menyerahkan bantuan buku dan perlengkapan sekolah.',
                'content' => '<h2>Lokasi Kunjungan</h2>
<p>Kunjungan dilakukan ke SD Negeri di Desa Terpencil, Kecamatan Mamuju Tengah, yang memiliki keterbatasan akses dan sarana pendidikan.</p>

<h2>Bantuan yang Diserahkan</h2>
<ul>
<li>Buku pelajaran untuk semua mata pelajaran</li>
<li>Alat tulis dan perlengkapan sekolah</li>
<li>Komputer dan peralatan IT</li>
<li>Buku bacaan untuk perpustakaan</li>
</ul>

<h2>Kondisi Sekolah</h2>
<p>Berdasarkan observasi, kondisi sekolah membutuhkan perhatian khusus:</p>
<ol>
<li>Gedung sekolah membutuhkan renovasi</li>
<li>Kurangnya fasilitas belajar yang memadai</li>
<li>Jarak tempuh siswa yang cukup jauh</li>
<li>Keterbatasan akses internet</li>
</ol>',
                'slug' => 'kunjungan-sekolah-dasar-terpencil',
                'category' => 'Pendidikan',
                'tags' => ['Sekolah', 'Bantuan', 'Daerah Terpencil'],
                'published_at' => now()->subDays(15),
                'views' => 890,
                'status' => 'published',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'title' => 'Rapat Kerja dengan Pemerintah Daerah',
                'excerpt' => 'Mengadakan rapat kerja untuk membahas program pembangunan daerah dan alokasi anggaran tahun 2024.',
                'content' => '<h2>Agenda Rapat Kerja</h2>
<p>Rapat kerja ini membahas program pembangunan daerah Sulawesi Barat untuk tahun 2024 dengan fokus pada peningkatan kesejahteraan masyarakat.</p>

<h2>Program Prioritas</h2>
<ul>
<li>Pembangunan infrastruktur jalan</li>
<li>Peningkatan akses air bersih</li>
<li>Pengembangan pariwisata daerah</li>
<li>Pemberdayaan ekonomi masyarakat</li>
</ul>

<h2>Alokasi Anggaran</h2>
<p>Total anggaran yang dialokasikan untuk program pembangunan daerah sebesar Rp 50 miliar dengan rincian:</p>
<ol>
<li>Infrastruktur: Rp 20 miliar</li>
<li>Pendidikan: Rp 15 miliar</li>
<li>Kesehatan: Rp 10 miliar</li>
<li>Ekonomi: Rp 5 miliar</li>
</ol>',
                'slug' => 'rapat-kerja-pemerintah-daerah',
                'category' => 'Pemerintahan',
                'tags' => ['Pembangunan', 'Anggaran', 'Pemerintah Daerah'],
                'published_at' => now()->subDays(18),
                'views' => 1340,
                'status' => 'published',
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(18),
            ],
            [
                'title' => 'Program Pelatihan Kewirausahaan untuk Pemuda',
                'excerpt' => 'Menyelenggarakan program pelatihan kewirausahaan untuk pemuda di Sulawesi Barat guna meningkatkan kemampuan berwirausaha.',
                'content' => '<h2>Tujuan Program</h2>
<p>Program ini bertujuan untuk meningkatkan kemampuan kewirausahaan pemuda di Sulawesi Barat agar dapat menciptakan lapangan kerja dan mengembangkan ekonomi daerah.</p>

<h2>Materi Pelatihan</h2>
<ul>
<li>Dasar-dasar kewirausahaan</li>
<li>Manajemen keuangan usaha</li>
<li>Pemasaran digital</li>
<li>Pengembangan produk</li>
</ul>

<h2>Target Peserta</h2>
<p>Program ini menargetkan 100 pemuda dari berbagai kecamatan di Sulawesi Barat dengan kriteria:</p>
<ol>
<li>Usia 18-35 tahun</li>
<li>Memiliki minat berwirausaha</li>
<li>Bersedia mengikuti pelatihan penuh</li>
<li>Memiliki ide bisnis yang potensial</li>
</ol>',
                'slug' => 'program-pelatihan-kewirausahaan-pemuda',
                'category' => 'Pemuda',
                'tags' => json_encode(['Pemuda', 'Kewirausahaan', 'Pelatihan']),
                'published_at' => now()->subDays(20),
                'views' => 750,
                'status' => 'published',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'title' => 'Sosialisasi Program Kesehatan Masyarakat',
                'excerpt' => 'Menyelenggarakan sosialisasi program kesehatan masyarakat untuk meningkatkan kesadaran akan pentingnya kesehatan di Sulawesi Barat.',
                'content' => '<h2>Program Kesehatan</h2>
<p>Program ini fokus pada peningkatan kesadaran masyarakat akan pentingnya kesehatan dan pencegahan penyakit.</p>

<h2>Kegiatan Utama</h2>
<ul>
<li>Pemeriksaan kesehatan gratis</li>
<li>Edukasi gizi seimbang</li>
<li>Program imunisasi anak</li>
<li>Kampanye hidup sehat</li>
</ul>

<h2>Target Sasaran</h2>
<p>Program ini menyasar seluruh lapisan masyarakat dengan prioritas:</p>
<ol>
<li>Ibu hamil dan balita</li>
<li>Lansia</li>
<li>Penderita penyakit kronis</li>
<li>Masyarakat di daerah terpencil</li>
</ol>',
                'slug' => 'sosialisasi-program-kesehatan-masyarakat',
                'category' => 'Kesehatan',
                'tags' => json_encode(['Kesehatan', 'Masyarakat', 'Pencegahan']),
                'published_at' => now()->subDays(22),
                'views' => 1100,
                'status' => 'published',
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
