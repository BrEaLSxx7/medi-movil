<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            'nombre'=>'Cancelado'
        ]);
        DB::table('states')->insert([
            'nombre'=>'Finalizado'
        ]);
        DB::table('states')->insert([
            'nombre'=>'Pendiente'
        ]);
    }
}
