<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert([
            'nombre' => 'Medico'
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Paciente'
        ]);
    }

}
