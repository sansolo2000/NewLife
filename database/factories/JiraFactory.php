<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\User;
use App\TipoPrioridad;
use App\TipoJira;
use App\Jira;
use App\TipoResponsable;
use Illuminate\Support\Carbon;

$factory->define(Jira::class, function (Faker $faker) {

    return [
        'tire_id'           => TipoResponsable::inRandomOrder()->where('tire_activo', '=', true)->where('tire_area', '=', 'Interno')->first()->tire_id,
        'ties_id'           => 1, 
        'tipr_id'           => TipoPrioridad::inRandomOrder()->where('tipr_activo', '=', true)->first()->tipr_id,
        'tiji_id'           => TipoJira::inRandomOrder()->where('tiji_activo', '=', true)->first()->tiji_id,
        'vers_id'           => 1,
        'user_id'           => User::where('area', '=', 'Interno')->select('id')->inRandomOrder()->get()->first()->id,
        'jira_codigo'       => $faker->unique()->randomElement($array = codigos_jiras()),
        'jira_asunto'       => $faker->realText(rand(40, 50)),
        'jira_descripcion'  => $faker->realText(rand(200, 800)),
        'jira_fecha'        => Carbon::parse($faker->dateTimeBetween('-3 years', 'now')),
        'jira_reportado'    => true,
        'jira_activo'       => true
    ];
});

