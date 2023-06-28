<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TourismTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=1; $i<50; $i++){
        $city_id = $faker->numberBetween($min = 1, $max = 2);
        $name = $faker->city;
        $description = $faker->catchPhrase;
        $photo = $faker->imageUrl($width = 320, $height = 240, 'tourism');
        $address = $faker->address;
        $latitude = $faker->latitude;
        $longitude = $faker->longitude;
        DB::table('tourism')->insert([
          'city_id' => $city_id,
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
