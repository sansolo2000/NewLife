<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(PostSeeder::class);
        $this->call(TipoEstadoSeeder::class);
        $this->call(TipoJiraSeeder::class);
        $this->call(TipoPrioridadSeeder::class);
        $this->call(TipoResponsablesSeeder::class);
        $this->call(TipoAccionesJirasSeeder::class);
        $this->call(VersionSeeder::class);
        $this->call(JiraSeeder::class);
        $this->call(JiraAccionSeeder::class); 
        $this->call(MensajeSeeder::class);
        $this->call(TipoVersionSeeder::class);


    }
}
