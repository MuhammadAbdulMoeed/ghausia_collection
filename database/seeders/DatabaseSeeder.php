<?php

namespace Database\Seeders;

use CouponSeeder;
use Illuminate\Database\Seeder;
use SettingTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ColorSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(CouponSeeder::class);
    }
}
