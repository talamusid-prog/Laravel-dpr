<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@dpr-ri.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create additional admin users
        User::create([
            'name' => 'Dr. Ir. H. AGUS AMBO DJIWA, M.P.',
            'email' => 'agus.ambo@dpr-ri.com',
            'password' => Hash::make('agus123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Tim Admin',
            'email' => 'tim.admin@dpr-ri.com',
            'password' => Hash::make('tim123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super Admin accounts created successfully!');
        $this->command->info('Super Admin: admin@dpr-ri.com / admin123');
        $this->command->info('Dr. AGUS: agus.ambo@dpr-ri.com / agus123');
        $this->command->info('Tim Admin: tim.admin@dpr-ri.com / tim123');
    }
}
