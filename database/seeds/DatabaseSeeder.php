<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(MerchantTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DetailTableSeeder::class);
        $this->call(RewardTableSeeder::class);
        $this->call(TourismTableSeeder::class);
        $this->call(MerchItemsTableSeeder::class);
        $this->call(PromoTableSeeder::class);
        $this->call(TrxReedemTableSeeder::class);
        $this->call(QrTableSeeder::class);
        $this->call(TrxQrTableSeeder::class);
    }
}
