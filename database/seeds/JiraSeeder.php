<?php

use App\Jira;
use App\JiraAccion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Generator;
use App\User;
use app\TipoAccionJira;

class JiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Jira::class, 100)->create();
        $faker = Faker\Factory::create();
        $jiras = Jira::all();
        foreach ($jiras as $jira) {
            $user = User::where('area', '=', 'Interno')->select('id', 'name')->inRandomOrder()->get()->first();
            $jiraAccion = new JiraAccion();
            $jiraAccion->jira_id = $jira->jira_id;
            $jiraAccion->tiaj_id = TipoAccionJira::tiaj_codigo_id('CREACION_JIRA');
            $jiraAccion->jiac_descripcion = ':: Creación de Jira por el usuarios '.$user->name.' ::';
            $jiraAccion->jiac_fecha = Carbon::parse($faker->dateTimeBetween('-3 years', 'now'));
            $jiraAccion->user_id = $user->id;
            $jiraAccion->jiac_activo = true;
            $jiraAccion->save();
            
        }
    }
}
