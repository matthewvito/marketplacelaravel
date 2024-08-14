<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class ProductsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
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

        Product::factory(100)->create();
    }
}
?>