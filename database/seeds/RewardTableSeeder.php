<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RewardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=0; $i<20; $i++){
        $point = $faker->numberBetween($min = 100, $max = 9000);
        $name = $faker->sentence($nbWords = 2, $variableNbWords = true);
        $description = $faker->sentence;
        $photo = $faker->imageUrl($width = 320, $height = 240, 'reward');
        DB::table('rewards')->insert([
          'point' => $point,
          'photo' => $photo,
          'name' => $name,
          'description' => $description,
        ]);
      }
    }
}
