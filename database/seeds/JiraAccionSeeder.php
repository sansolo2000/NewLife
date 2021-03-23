<?php

use Illuminate\Database\Seeder;
use App\Jira;
use App\User;
use App\JiraAccion;
use App\TipoAccionJira;
use Illuminate\Support\Carbon;
use Faker\Generator;

class JiraAccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $jiras = Jira::all();
        $faker = Faker\Factory::create();

        foreach ($jiras as $jira) {
            if ($jira->jira_id%2==0){
                $Fecha = Carbon::parse($faker->dateTimeBetween('-2 days', 'now'));
                $user = User::where('area', '=', 'Interno')->select('id', 'name')->inRandomOrder()->get()->first();
                $jiraAccion = new JiraAccion();
                $jiraAccion->jira_id = $jira->jira_id;
                $jiraAccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('DIAGNOSTICO_ESTIMACION');
                $jiraAccion->jiac_descripcion = ':: Diagnostico y estimación entregada por '.$user->name.' ::';
                $jiraAccion->jiac_fecha = $Fecha;
                $jiraAccion->user_id = $user->id;
                $jiraAccion->jiac_activo = true;
                $jiraAccion->save();


                $user = User::where('area', '=', 'Externo')->select('id', 'name')->inRandomOrder()->get()->first();
                $jiraAccion = new JiraAccion();
                $jiraAccion->jira_id = $jira->jira_id;
                $jiraAccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('APROBACION_DIAGNOSTICO');
                $jiraAccion->jiac_descripcion = ':: Aprobación Diagnóstico por '.$user->name.' ::';
                $jiraAccion->jiac_fecha = Carbon::parse($faker->dateTimeBetween($Fecha, 'now'));
                $jiraAccion->user_id = $user->id;
                $jiraAccion->jiac_activo = true;
                $jiraAccion->save();

                
                $jira->ties_id = 4;
                $jira->save();
            }
            else{
                if ($jira->jira_id%5==0){
                    $Fecha = Carbon::parse($faker->dateTimeBetween('-2 days', 'now'));
                    $user = User::where('area', '=', 'Interno')->select('id', 'name')->inRandomOrder()->get()->first();
                    $jiraAccion = new JiraAccion();
                    $jiraAccion->jira_id = $jira->jira_id;
                    $jiraAccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('SOLICITUD_INFORMACION');
                    $jiraAccion->jiac_descripcion = ':: Solicitud de información '.$user->name.' ::';
                    $jiraAccion->jiac_fecha = $Fecha;
                    $jiraAccion->user_id = $user->id;
                    $jiraAccion->jiac_activo = true;
                    $jiraAccion->save();

                    
                    $jira->ties_id = 4;
                    $jira->save();                
                }
            }
        }



    }
}
