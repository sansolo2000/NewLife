<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = Permission::defaultPermissions();

 
        // create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAuthorHLF = Role::create(['name' => 'author_externo']);
        $roleAuthorIndra = Role::create(['name' => 'author_interno']);
        $roleUser = Role::create(['name' => 'user']);

        $roleAdmin->syncPermissions(Permission::all());
//        $roleAdmin->revokePermissionTo(Permission::where('name', '=', 'delete jiraaccion')->get());
        $roleAuthorIndra->syncPermissions(Permission::where('name', 'like', '%jira%')->get());
        $roleAuthorIndra->revokePermissionTo(Permission::where('name', 'like', '%delete%')->get());
        $roleAuthorHLF->syncPermissions(Permission::where('name', 'like', '%jiraaccion%')
                            ->orwhere('name', 'like', '%view jira%')->get());
        $roleAuthorIndra->givePermissionTo(Permission::where('name', 'like', '%version%')->get());
        $roleAuthorHLF->givePermissionTo(Permission::where('name', 'like', '%version%')->get());
        $roleAuthorHLF->revokePermissionTo(Permission::where('name', 'like', '%delete%')->get());
        //$role->givePermissionTo($permission);

    }
}
