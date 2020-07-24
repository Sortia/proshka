<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET GLOBAL FOREIGN_KEY_CHECKS=0;');

        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);

        DB::statement('SET GLOBAL FOREIGN_KEY_CHECKS=1;');
    }
}
