<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoPrioridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_prioridades')->insert([
            'tipr_nombre'   =>  'Normal',
            'tipr_indice'   =>  1,
            'tipr_activo'   =>  true
        ]);
        DB::table('tipo_prioridades')->insert([
            'tipr_nombre'   =>  'Bloqueante',
            'tipr_indice'   =>  2,
            'tipr_activo'   =>  true
        ]);
    }
}
