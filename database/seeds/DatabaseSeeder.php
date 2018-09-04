<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(DocumentTableSeeder::class);
        $this->call(HourTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(StateTableSeeder::class);
    }

}
