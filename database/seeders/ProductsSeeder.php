<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Smart TV 55” 4K Samsung',
                'price' => 2699
            ],
            [
                'name' => 'Apple iPhone 16 Pro Max',
                'price' => 9599
            ],
            [
                'name' => 'PlayStation 5 Slim Edição Digital ',
                'price' => 3500
            ],
        ]);
    }
}
