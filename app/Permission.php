<?php

namespace App;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    public static function defaultPermissions()
    {

        
        return [
            'view role',
            'create role',
            'edit role',
            'delete role',

            'view user',
            'create user',
            'edit user',
            'delete user',

            'view tipoaccionjira',
            'create tipoaccionjira',
            'edit tipoaccionjira',
            'delete tipoaccionjira',

            'view jira',
            'create jira',
            'edit jira',
            'delete jira',
            'notes jira',

            'view jiraaccion',
            'create jiraaccion',
            'edit jiraaccion',
            'delete jiraaccion',        

            'view version',
            'create version',
            'edit version',
            'delete version',        

            'view versionaccion',
            'create versionaccion',
            'edit versionaccion',
            'delete versionaccion', 
            'asignar jiras',     
            'cargar incidente',     
              
        ];
    }

    public function isDeleteLabel()
    {
        return Str::contains($this->name, 'delete') ? 'text-danger' : null;
    }

}
