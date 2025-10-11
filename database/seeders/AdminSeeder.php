<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Aspiration;
use App\Models\Event;
use App\Models\Setting;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Articles
        Article::create([
            'title' => 'Pembangunan Infrastruktur Jalan di NTB Capai 85%',
            'slug' => 'pembangunan-infrastruktur-jalan-ntb-85',
            'excerpt' => 'Komitmen untuk mempercepat pembangunan infrastruktur di Nusa Tenggara Barat sebagai upaya meningkatkan konektivitas dan pertumbuhan ekonomi daerah.',
            'content' => 'Pembangunan infrastruktur jalan di Nusa Tenggara Barat telah mencapai 85% dari target yang ditetapkan. Program ini merupakan bagian dari komitmen untuk meningkatkan konektivitas antar daerah dan mendukung pertumbuhan ekonomi lokal.',
            'featured_image' => '/berita1.jpg',
            'status' => 'published',
            'views' => 1250,
            'published_at' => now()->subDays(5),
        ]);

        Article::create([
            'title' => 'Program Beasiswa untuk 1000 Mahasiswa NTB',
            'slug' => 'program-beasiswa-1000-mahasiswa-ntb',
            'excerpt' => 'Inisiatif baru untuk memberikan kesempatan pendidikan yang lebih baik bagi generasi muda Nusa Tenggara Barat.',
            'content' => 'Program beasiswa ini ditujukan untuk 1000 mahasiswa berprestasi di Nusa Tenggara Barat. Program ini bertujuan untuk meningkatkan akses pendidikan tinggi dan mendukung pengembangan sumber daya manusia daerah.',
            'featured_image' => '/berita2.jpg',
            'status' => 'published',
            'views' => 980,
            'published_at' => now()->subDays(3),
        ]);

        Article::create([
            'title' => 'Bantuan UMKM Mencapai Rp 5 Miliar di 2024',
            'slug' => 'bantuan-umkm-5-miliar-2024',
            'excerpt' => 'Berbagai program dan bantuan untuk mengembangkan usaha mikro, kecil, dan menengah di wilayah NTB.',
            'content' => 'Total bantuan UMKM yang telah disalurkan mencapai Rp 5 miliar pada tahun 2024. Program ini meliputi bantuan modal, pelatihan, dan pendampingan untuk pengembangan usaha.',
            'featured_image' => '/berita3.jpg',
            'status' => 'draft',
            'views' => 0,
        ]);

        // Sample Galleries
        Gallery::create([
            'title' => 'Kunjungan Kerja ke Pasangkayu',
            'description' => 'Dokumentasi kunjungan kerja ke Kabupaten Pasangkayu untuk menyerap aspirasi masyarakat',
            'image_path' => '/gallery1.jpg',
            'thumbnail_path' => '/gallery1-thumb.jpg',
            'category' => 'Kunjungan Kerja',
            'location' => 'Pasangkayu, Sulawesi Barat',
            'photographer' => 'Tim Dokumentasi',
            'is_featured' => true,
        ]);

        Gallery::create([
            'title' => 'Rapat Koordinasi DPR-RI',
            'description' => 'Rapat koordinasi dengan anggota DPR-RI lainnya',
            'image_path' => '/gallery2.jpg',
            'thumbnail_path' => '/gallery2-thumb.jpg',
            'category' => 'Rapat',
            'location' => 'Jakarta',
            'photographer' => 'Tim Dokumentasi',
            'is_featured' => false,
        ]);

        // Sample Aspirations
        Aspiration::create([
            'title' => 'Perbaikan Jalan di Desa Pasangkayu',
            'description' => 'Permintaan perbaikan jalan di Desa Pasangkayu yang sudah rusak parah dan mengganggu aktivitas warga',
            'category' => 'infrastruktur',
            'status' => 'diproses',
            'submitter_name' => 'Ahmad Suryadi',
            'submitter_email' => 'ahmad.suryadi@email.com',
            'submitter_phone' => '081234567890',
        ]);

        Aspiration::create([
            'title' => 'Bantuan Modal untuk UMKM',
            'description' => 'Permohonan bantuan modal untuk pengembangan usaha kecil menengah di wilayah NTB',
            'category' => 'umkm',
            'status' => 'baru',
            'submitter_name' => 'Siti Nurhaliza',
            'submitter_email' => 'siti.nurhaliza@email.com',
            'submitter_phone' => '081234567891',
        ]);

        Aspiration::create([
            'title' => 'Program Kesehatan Gratis',
            'description' => 'Usulan program kesehatan gratis untuk masyarakat kurang mampu di daerah terpencil',
            'category' => 'kesehatan',
            'status' => 'selesai',
            'submitter_name' => 'Dr. Budi Santoso',
            'submitter_email' => 'budi.santoso@email.com',
            'submitter_phone' => '081234567892',
            'admin_response' => 'Program kesehatan gratis telah disetujui dan akan segera dilaksanakan',
            'responded_at' => now()->subDays(2),
        ]);

        // Sample Events
        Event::create([
            'title' => 'Sidang Paripurna DPR-RI',
            'description' => 'Sidang paripurna DPR-RI membahas RUU tentang pembangunan infrastruktur',
            'type' => 'sidang',
            'status' => 'terjadwal',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3)->addHours(4),
            'location' => 'Gedung DPR-RI, Jakarta',
            'participants' => ['Dr. Ir. H. AGUS AMBO DJIWA, M.P.', 'Anggota DPR-RI lainnya'],
        ]);

        Event::create([
            'title' => 'Rapat Koordinasi dengan Pemerintah Daerah',
            'description' => 'Rapat koordinasi dengan pemerintah daerah Sulawesi Barat',
            'type' => 'rapat',
            'status' => 'berlangsung',
            'start_date' => now()->subHours(2),
            'end_date' => now()->addHours(2),
            'location' => 'Kantor Gubernur Sulawesi Barat',
            'participants' => ['Gubernur Sulawesi Barat', 'Dr. Ir. H. AGUS AMBO DJIWA, M.P.'],
        ]);

        // Sample Settings
        Setting::create([
            'key' => 'site_name',
            'value' => 'Dr. Ir. H. AGUS AMBO DJIWA, M.P.',
            'type' => 'string',
            'description' => 'Nama website',
        ]);

        Setting::create([
            'key' => 'site_description',
            'value' => 'Anggota DPR-RI periode 2024-2029 yang berkomitmen melayani masyarakat dan menyerap aspirasi untuk kemajuan daerah.',
            'type' => 'string',
            'description' => 'Deskripsi website',
        ]);

        Setting::create([
            'key' => 'primary_color',
            'value' => '#3B82F6',
            'type' => 'string',
            'description' => 'Warna primer website',
        ]);

        Setting::create([
            'key' => 'contact_email',
            'value' => 'info@haerulhadi.com',
            'type' => 'string',
            'description' => 'Email kontak',
        ]);

        Setting::create([
            'key' => 'contact_phone',
            'value' => '+62 852-4276-6676',
            'type' => 'string',
            'description' => 'Nomor telepon kontak',
        ]);
    }
}
