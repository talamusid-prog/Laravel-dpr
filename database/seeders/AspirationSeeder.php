<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use Illuminate\Database\Seeder;

class AspirationSeeder extends Seeder
{
    public function run(): void
    {
        $aspirations = [
            [
                'title' => 'Aspirasi dari John Doe',
                'description' => 'Saya ingin mengajukan aspirasi mengenai perbaikan jalan di desa kami yang sudah rusak parah. Jalan ini sangat penting untuk akses ke sekolah dan puskesmas. Kondisi jalan yang buruk membuat sulit bagi warga untuk beraktivitas sehari-hari.',
                'submitter_name' => 'John Doe',
                'submitter_email' => 'john@example.com',
                'category' => 'infrastruktur',
                'status' => 'baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Aspirasi dari Sarah Wilson',
                'description' => 'Saya ingin mengusulkan program beasiswa untuk siswa berprestasi di daerah kami. Banyak anak-anak yang memiliki potensi akademik tinggi namun terkendala biaya pendidikan. Program ini akan sangat membantu meningkatkan kualitas pendidikan di daerah kami.',
                'submitter_name' => 'Sarah Wilson',
                'submitter_email' => 'sarah@example.com',
                'category' => 'pendidikan',
                'status' => 'diproses',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'title' => 'Aspirasi dari Ahmad Rahman',
                'description' => 'Saya ingin mengusulkan pembangunan pusat kesehatan masyarakat yang lebih lengkap di desa kami. Saat ini warga harus pergi jauh untuk mendapatkan pelayanan kesehatan yang memadai. Dengan adanya puskesmas yang lengkap, warga akan lebih mudah mengakses layanan kesehatan.',
                'submitter_name' => 'Ahmad Rahman',
                'submitter_email' => 'ahmad@example.com',
                'category' => 'kesehatan',
                'status' => 'selesai',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
                'admin_response' => 'Terima kasih atas aspirasi Anda. Kami telah menindaklanjuti usulan ini dan akan mempertimbangkan pembangunan puskesmas baru di daerah tersebut.',
                'responded_at' => now()->subDays(1),
            ],
            [
                'title' => 'Aspirasi dari Maria Santos',
                'description' => 'Saya ingin mengusulkan program pelatihan kewirausahaan untuk ibu-ibu di desa kami. Program ini akan membantu meningkatkan ekonomi keluarga dan memberdayakan perempuan di daerah kami. Dengan pelatihan yang tepat, ibu-ibu bisa memulai usaha kecil yang produktif.',
                'submitter_name' => 'Maria Santos',
                'submitter_email' => 'maria@example.com',
                'category' => 'ekonomi',
                'status' => 'baru',
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3),
            ],
            [
                'title' => 'Aspirasi dari Budi Santoso',
                'description' => 'Saya ingin mengusulkan program pelestarian lingkungan di daerah kami. Banyak hutan yang mulai berkurang dan sungai yang tercemar. Kami membutuhkan program yang komprehensif untuk menjaga kelestarian alam di daerah kami agar tetap lestari untuk generasi mendatang.',
                'submitter_name' => 'Budi Santoso',
                'submitter_email' => 'budi@example.com',
                'category' => 'lingkungan',
                'status' => 'diproses',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(6),
            ],
        ];

        foreach ($aspirations as $aspiration) {
            Aspiration::create($aspiration);
        }
    }
}
