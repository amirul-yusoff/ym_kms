<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

use App\Http\Models\module;
use App\Http\Models\Member;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Need to read from the module table to auto populate this

        $modules = module::get();
        foreach($modules as $module) {
//            Permission::create(['name' => 'edit '.$module->module_name]);
 //           Permission::create(['name' => 'delete '.$module->module_name]);
  //          Permission::create(['name' => 'create '.$module->module_name]);
   //         Permission::create(['name' => 'unpublish '.$module->module_name]);
        }
        // create permissions


        // create roles and assign existing permissions
        $roleProjectManager = Role::create(['name' => 'project-manager']);
        $roleProjectEngineer = Role::create(['name' => 'project-engineer']);
        $roleProjectAdmin = Role::create(['name' => 'project-admin']);
        $roleITAdmin = Role::create(['name' => 'it-admin']);
        $roleAccountAll = Role::create(['name' => 'account-all']);
        $roleAccountReceivable = Role::create(['name' => 'account-receivable']);
        $roleAccountPayable = Role::create(['name' => 'account-payable']);
        $roleProcurementAll = Role::create(['name' => 'procurement-all']);
        $roleProcurementSubcon = Role::create(['name' => 'procurement-subcon']);
        $roleBusinessDevelopment = Role::create(['name' => 'business-development']);
        $roleContractAdmin = Role::create(['name' => 'contract-admin']);

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider


        Member::find(326)->assignRole($role3);
    }
}
