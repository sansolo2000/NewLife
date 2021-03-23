<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\TipoAccionJira;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('versiones')->insert([
            'vers_nombre'           =>  'Sin Versión',
            'vers_activo'           =>  true,
            'vers_fecha_creacion'   =>  date('Y-m-d'), 
            'user_id'               =>  1
        ]);
        DB::table('versiones_acciones')->insert([
            'vers_id'       => 1, 
            'tiaj_id'       => TipoAccionJira::tiaj_codigo_id('CREACION_VERSION'),
            'veac_nombre'   => 'Versión inicial', 
            'veac_fecha'    => date('Y-m-d'), 
            'veac_activo'   => true, 
            'user_id'       => 1
        ]);

    }
}
