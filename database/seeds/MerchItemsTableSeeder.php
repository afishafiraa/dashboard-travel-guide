<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MerchItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=1; $i<30; $i++){
        for ($j=0; $j < 10; $j++) { 
          $merchant_id = $i;
          $name = $faker->sentence($nbWords = 2, $variableNbWords = true);
          $description = $faker->sentence;
          $photo = $faker->imageUrl($width = 320, $height = 240, 'item');
          $price = $faker->numberBetween($min = 10000, $max = 1000000);
          DB::table('merchant_items')->insert([
            'merchant_id' => $merchant_id,
            'name' => $name,
            'description' => $description,
            'photo' => $photo,
            'price' => $price,
          ]);
        }
      }
    }
}
