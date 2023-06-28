<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PromoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=1; $i<71; $i++){
        $item_id = $faker->numberBetween($min = 1, $max = 100);
        $value = $faker->numberBetween($min = 5, $max = 50);
        $category = 'discount';
        $description = $faker->sentence;
        $start_time = $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null);
        $tambah_hari = rand(3,14);
        $tambah = date('Y/m/d',strtotime(date_format($start_time, "Y/m/d").' + '.$tambah_hari.' days'));
        $end_time = $faker->dateTimeBetween($startDate = $start_time, $endDate = $tambah, $timezone = null);
        DB::table('promos')->insert([
          'item_id' => $item_id,
          'value' => $value,
          'category' => $category,
          'description' => $description,
          'start_time' => $start_time,
          'end_time' => $end_time,
        ]);
      }
    }
}
