<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::create(['name'=>'Create-Cities', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Cities', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Cities', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Cities', 'guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Profission', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Profission', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Profission', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Profission', 'guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Admin', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Admin', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Admin', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Admin', 'guard_name'=>'admin']);

        // Permission::create(['name'=>'Create-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Read-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Updata-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Delete-', 'guard_name'=>'admin']);
    }
}
