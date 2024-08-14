<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use Database\Factories\StoreFactory;
use Illuminate\Support\Facades\Hash;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $now = now();
        // DB::table('stores')->insert([
        //     'name' => 'Toko Buku',
        //     'address' => 'Jl. Raya No. 123',
        //     'phone' => '08123456789',
        //     'created_at' => $now,
        //     'updated_at' => $now
        // ]);

        // DB::table('stores')->insert([
        //     'name' => 'Toko Elektronik',
        //     'address' => 'Jl. Raya No. 456',
        //     'phone' => '08987654321',
        //     'created_at' => $now,
        //     'updated_at' => $now
        // ]);
        Store::factory(100)->create();
    }
}
