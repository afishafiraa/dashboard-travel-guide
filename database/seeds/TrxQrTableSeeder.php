<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TrxQrTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=0; $i<500; $i++){
        $qrcode_id = $faker->numberBetween($min = 1, $max = 100);
        $trx_time  = $faker->dateTimeBetween($startDate = '-1 months', $endDate = '+1 months', $timezone = null);

        DB::table('trx_qrcode')->insert([
          'qrcode_id' => $qrcode_id,
          'trx_time' => $trx_time,
        ]);
      }
    }
}
