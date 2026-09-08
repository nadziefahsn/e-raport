<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Seeders\SekolahSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SekolahSeeder::class);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'guru']);

        $admin = User::create([
            'name'     => 'Admin Utama',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        $guru = User::create([
            'name'     => 'Guru Contoh',
            'email'    => 'guru@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        $guru->assignRole('guru');
    }

}
