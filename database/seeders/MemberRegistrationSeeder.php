<?php

namespace Database\Seeders;

use App\Models\MemberRegistration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrations = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@email.com',
                'phone' => '081234567890',
                'birthdate' => '1995-03-15',
                'gender' => 'Laki-laki',
                'education' => 'S1',
                'occupation' => 'Software Developer',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'status' => 'pending',
                'submitted_at' => now()->subDays(2)
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'phone' => '081234567891',
                'birthdate' => '1992-07-22',
                'gender' => 'Perempuan',
                'education' => 'S2',
                'occupation' => 'Guru',
                'address' => 'Jl. Pendidikan No. 456, Bandung',
                'status' => 'approved',
                'submitted_at' => now()->subDays(3)
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567892',
                'birthdate' => '1988-11-08',
                'gender' => 'Laki-laki',
                'education' => 'SMA/SMK',
                'occupation' => 'Wiraswasta',
                'address' => 'Jl. Usaha No. 789, Surabaya',
                'status' => 'rejected',
                'submitted_at' => now()->subDays(4)
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@email.com',
                'phone' => '081234567893',
                'birthdate' => '1990-05-12',
                'gender' => 'Perempuan',
                'education' => 'D3',
                'occupation' => 'Perawat',
                'address' => 'Jl. Kesehatan No. 321, Yogyakarta',
                'status' => 'pending',
                'submitted_at' => now()->subDays(1)
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki.pratama@email.com',
                'phone' => '081234567894',
                'birthdate' => '1993-09-25',
                'gender' => 'Laki-laki',
                'education' => 'S1',
                'occupation' => 'Akuntan',
                'address' => 'Jl. Ekonomi No. 654, Medan',
                'status' => 'approved',
                'submitted_at' => now()->subDays(5)
            ]
        ];

        foreach ($registrations as $registration) {
            MemberRegistration::create($registration);
        }
    }
}
