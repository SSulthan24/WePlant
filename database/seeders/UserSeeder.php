<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or Update Admin User
        User::updateOrCreate(
            ['email' => 'admin@weplant.com'],
            [
                'name' => 'Admin WePlan(t)',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create or Update Farmer User
        User::updateOrCreate(
            ['email' => 'petani@weplant.com'],
            [
                'name' => 'Petani Test',
                'password' => Hash::make('petani123'),
                'role' => 'farmer',
            ]
        );

        // Create or Update Partner User
        User::updateOrCreate(
            ['email' => 'mitra@weplant.com'],
            [
                'name' => 'Mitra Test',
                'password' => Hash::make('mitra123'),
                'role' => 'partner',
            ]
        );

        $this->command->info('User Admin, Petani, dan Mitra berhasil dibuat/diupdate!');
        $this->command->info('Admin: admin@weplant.com / admin123');
        $this->command->info('Petani: petani@weplant.com / petani123');
        $this->command->info('Mitra: mitra@weplant.com / mitra123');
    }
}
