<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TrxReedemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=1; $i<70; $i++){
        $user_id = $faker->numberBetween($min = 21, $max = 50);
        $reward_id = $faker->numberBetween($min = 1, $max = 20);
        $created_at = $faker->dateTimeThisYear($max = 'now', $timezone = null);
        DB::table('trx_reedem')->insert([
          'user_id' => $user_id,
          'reward_id' => $reward_id,
          'created_at' => $created_at,
        ]);
      }
    }
}
