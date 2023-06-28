<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      for($i=0; $i<47; $i++){
        $user = factory(\App\User::class)->create();
        if ($i>20) {
          $user->assignRole('merchant');
        }else {
          $user->assignRole('guide');
        }
      }
    }
}
