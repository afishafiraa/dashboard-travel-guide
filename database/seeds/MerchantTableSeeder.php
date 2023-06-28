<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MerchantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=0; $i<30; $i++){
        $category_id = $faker->numberBetween($min = 1, $max = 3);
        $city_id = $faker->numberBetween($min = 1, $max = 2);
        $name = $faker->company;
        $description = $faker->catchPhrase;
        $photo = $faker->imageUrl($width = 320, $height = 240, 'merchant');
        $address = $faker->address;
        $latitude = $faker->latitude;
        $longitude = $faker->longitude;
        DB::table('merchants')->insert([
          'category_id' => $category_id,
          'name' => $name,
          'description' => $description,
          'photo' => $photo,
          'address' => $address,
          'latitude' => $latitude,
          'longitude' => $longitude,
        ]);
      }
    }
}
