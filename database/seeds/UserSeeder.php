<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('password'); // password
        $user->area = 'Interno';
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'Hector Sanchez';
        $user->email = 'sansolo@gmail.com';
        $user->password = bcrypt('$rm4g3d0n'); // password
        $user->area = 'Interno';
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'Usuario Indra Autor';
        $user->email = 'autorindra@indra.com';
        $user->password = bcrypt('password'); // password
        $user->area = 'Interno';
        $user->save();
        $user->assignRole('author_interno');

        $user = new User();
        $user->name = 'Usuario HLF Autor';
        $user->email = 'autorhlf@hlf.cl';
        $user->password = bcrypt('password'); // password
        $user->area = 'Externo';
        $user->save();
        $user->assignRole('author_externo');

        $user = new User();
        $user->name = 'Normal Indra Lector';
        $user->email = 'lectorindra@indra.com';
        $user->password = bcrypt('password'); // password
        $user->area = 'Interno';
        $user->save();
        $user->assignRole('user');


        $user = new User();
        $user->name = 'Normal HLF Lector';
        $user->email = 'lectorhlf@hlf.cl';
        $user->password = bcrypt('password'); // password
        $user->area = 'Externo';
        $user->save();
        $user->assignRole('user');
    }
}
