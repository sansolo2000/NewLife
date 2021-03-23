<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoJiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Correctivo',
            'tiji_sistema'      =>  'HN',
            'tiji_indice'       =>  1,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Soporte Funcional(FS)',
            'tiji_sistema'      =>  'HN',
            'tiji_indice'       =>  2,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Incidentes internos (CDT y IDT)',
            'tiji_indice'       =>  3,
            'tiji_sistema'      =>  'HN',
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Desarrollo Evolutivos(FR)',
            'tiji_sistema'      =>  'HN',
            'tiji_indice'       =>  4,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  false
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Correctivo',
            'tiji_sistema'      =>  'SAP',
            'tiji_indice'       =>  5,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Soporte Funcional(FS)',
            'tiji_sistema'      =>  'SAP',
            'tiji_indice'       =>  6,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Incidentes internos (CDT y IDT)',
            'tiji_sistema'      =>  'SAP',
            'tiji_indice'       =>  7,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  true
        ]);
        DB::table('tipo_jiras')->insert([
            'tiji_nombre'       =>  'Desarrollo Evolutivos(FR)',
            'tiji_sistema'      =>  'SAP',
            'tiji_indice'       =>  8,
            'tiji_activo'       =>  true,
            'tiji_servicesdesk' =>  false
        ]);
    }
}
