<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('category_merchant')->insert([
        'name'=>'store',
        'description'=>'Toko penjual barang maupun makanan.'
      ]);
      DB::table('category_merchant')->insert([
        'name'=>'hotel',
        'description'=>'Hotel maupun tempat menginap.'
      ]);
      DB::table('category_merchant')->insert([
        'name'=>'restaurant',
        'description'=>'Tempat makan.'
      ]);
    }
}
