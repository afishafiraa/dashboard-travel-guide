<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('city')->insert([
        'name'=>'Yogyakarta',
        'latitude'=>'-7.803164.',
        'longitude'=>'110.3398254'
      ]);
      DB::table('city')->insert([
        'name'=>'Bali',
        'latitude'=>'-8.4553172.',
        'longitude'=>'114.7913494'
      ]);
    }
}
