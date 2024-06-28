<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Ethnic;
use App\Models\Institution;
use App\Models\Module;
use App\Models\Religion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@karakterbuahroh.com',
            'name' => 'admin2024',
            'password' => bcrypt('admin2024'),
        ]);

        Module::create([
            'name' => 'Kasih',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 1,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Sukacita',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 2,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Damai Sejahtera',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 3,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Kesabaran',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 4,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Kemurahan',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 5,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Kebaikan',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 6,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Kesetiaan',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 7,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Kelemah-lembutan',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 8,
            'price' => 0,
        ]);
        Module::create([
            'name' => 'Penguasaan Diri',
            'is_active' => true,
            'color' => '#000000',
            'order_number' => 9,
            'price' => 0,
        ]);

        //create religion 5 in indonesia

        Religion::create([
            'name' => 'Islam',
        ]);
        Religion::create([
            'name' => 'Kristen',
        ]);
        Religion::create([
            'name' => 'Katolik',
        ]);
        Religion::create([
            'name' => 'Hindu',
        ]);
        Religion::create([
            'name' => 'Budha',
        ]);
        Religion::create([
            'name' => 'Lainnya',
        ]);

        //create suku Jawa, Batak, Sunda, Minang, Bugis, Lainnya
        Ethnic::create([
            'name' => 'Jawa',
        ]);
        Ethnic::create([
            'name' => 'Batak',
        ]);
        Ethnic::create([
            'name' => 'Sunda',
        ]);
        Ethnic::create([
            'name' => 'Minang',
        ]);
        Ethnic::create([
            'name' => 'Bugis',
        ]);
        Ethnic::create([
            'name' => 'Lainnya',
        ]);

        Institution::create([
            'name' => 'Universitas Ciputra',
        ]);
        Institution::create([
            'name' => 'Sekolah Ciputra',
        ]);

        Education::create([
            'name' => 'SD',
        ]);
        Education::create([
            'name' => 'SMP',
        ]);
        Education::create([
            'name' => 'SMA',
        ]);
        Education::create([
            'name' => 'D3',
        ]);
        Education::create([
            'name' => 'S1',
        ]);
    }
}
