<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=1; $i<51; $i++){
        $user_id  = $i;
        $phone_number = $faker->e164PhoneNumber;
        $ocupation = $faker->jobTitle;
        $photo = $faker->imageUrl($width = 320, $height = 240, 'people');
        $address = $faker->address;
        DB::table('user_detail')->insert([
          'user_id' => $user_id,
          'photo' => $photo,
          'phone_number' => $phone_number,
          'ocupation' => $ocupation,
          'address' => $address,
        ]);
      }
    }
}
