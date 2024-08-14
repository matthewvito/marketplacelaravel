<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $now = now();
        // DB::table('products')->insert([
        //     'name' => 'Produk A',
        //     'price' => 100,
        //     'stock' => 50,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

        // DB::table('products')->insert([
        //     'name' => 'Produk B',
        //     'price' => 150,
        //     'stock' => 30,
        //     'created_at' => $now,
           
        //     'updated_at' => $now,
        // ]);
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            StoreSeeder::class,
            ProductsTableSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
