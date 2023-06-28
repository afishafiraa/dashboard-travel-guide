<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QrTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=0; $i<100; $i++){
        $user_id = $faker->numberBetween($min = 21, $max = 50);
        $promo_id = $faker->numberBetween($min = 1, $max = 70);
        $expiry_time = $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years', $timezone = null);

        DB::table('qrcode')->insert([
          'user_id' => $user_id,
          'promo_id' => $promo_id,
          'expiry_time' => $expiry_time,
        ]);
      }
    }
}
