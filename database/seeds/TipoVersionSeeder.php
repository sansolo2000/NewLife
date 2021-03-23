<?php

use App\TipoJira;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $TiposJiras = TipoJira::where('tiji_activo', true)->get();

        foreach ($TiposJiras as $TipoJira){
            DB::table('tipos_versiones')->insert([
                'tiji_id'       =>  $TipoJira['tiji_id'],
                'vers_id'       =>  1,
            ]);    
        }
    }
}
