<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apotek;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Apotek::create([
            'nama' => 'Kozuki Momonosuke',
            'rujukan' => 1,
            'rumah_sakit' => 'RS Moga Sembuh',
            'obat' => ['Paracetamol', 'Dexametasol'],
            'harga_satuan' => [15000, 10000],
            'total_harga' => 15000 + 10000,
            'apoteker' => 'Kamachi'
        ]);

        Apotek::create([
            'nama' => 'Raul',
            'rujukan' => 0,
            'rumah_sakit' => null,
            'obat' => ['Tramadol', 'Sianida'],
            'harga_satuan' => [23000, 56000],
            'total_harga' => 23000 + 56000,
            'apoteker' => 'Kamachi'
        ]);
    }
}
