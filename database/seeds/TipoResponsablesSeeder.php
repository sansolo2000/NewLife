<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TipoResponsablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_responsables')->insert([
            'tire_nombre'       =>  'BiosLis',
            'tire_indice'       =>  1,
            'tire_activo'       =>  true,
            'tire_area'         =>  'Interno',
            'tire_asignable'    =>  false
        ]);
        DB::table('tipo_responsables')->insert([
            'tire_nombre'       =>  'Chile',
            'tire_indice'       =>  2,
            'tire_activo'       =>  true,
            'tire_area'         =>  'Interno',
            'tire_asignable'    =>  true
        ]);
        DB::table('tipo_responsables')->insert([
            'tire_nombre'       =>  'Producto',
            'tire_indice'       =>  3,
            'tire_activo'       =>  true,
            'tire_area'         =>  'Interno',
            'tire_asignable'    =>  false
        ]);
        DB::table('tipo_responsables')->insert([
            'tire_nombre'       =>  'SAP',
            'tire_indice'       =>  4,
            'tire_activo'       =>  true,
            'tire_area'         =>  'Interno',
            'tire_asignable'    =>  true
        ]);
        DB::table('tipo_responsables')->insert([
            'tire_nombre'       =>  'HLF',
            'tire_indice'       =>  5,
            'tire_activo'       =>  true,
            'tire_area'         =>  'Externo',
            'tire_asignable'    =>  true
        ]);
    }
}
