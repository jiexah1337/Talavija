<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
//        $this->call(RepatriationTableSeeder::class);
        $this->call(StatusTableSeeder::class);
//        $this->call(NewsSeeder::class);

    }
}
