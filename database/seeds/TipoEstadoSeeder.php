<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_estados')->insert([
            'ties_nombre'       =>  'Abierta',
            'ties_estado_sd'    =>  'En desarrollo',
            'ties_indice'       =>  1,
            'ties_activo'       =>  true
        ]);
        DB::table('tipo_estados')->insert([
            'ties_nombre'       =>  'Cerrada',
            'ties_estado_sd'    =>  'Cerrado',            
            'ties_indice'       =>  2,
            'ties_activo'       =>  true
        ]);
        DB::table('tipo_estados')->insert([
            'ties_nombre'       =>  'Entregada',
            'ties_estado_sd'    =>  'Entregado',            
            'ties_indice'       =>  3,
            'ties_activo'       =>  true
        ]);
        DB::table('tipo_estados')->insert([
            'ties_nombre'       =>  'Pendiente HLF',
            'ties_estado_sd'    =>  'En desarrollo',
            'ties_indice'       =>  4,
            'ties_activo'       =>  true
        ]);
    }
}
