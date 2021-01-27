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

        Permission::create(['name'=>'Create-User', 'guard_name'=>'user']);
        Permission::create(['name'=>'Read-User', 'guard_name'=>'user']);
        Permission::create(['name'=>'Updata-User', 'guard_name'=>'user']);
        Permission::create(['name'=>'Delete-User', 'guard_name'=>'user']);

        Permission::create(['name'=>'Create-Currency', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Currency', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Currency', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Currency', 'guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Income_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Income_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Income_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Income_Type', 'guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Expense_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Read-Expense_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Updata-Expense_Type', 'guard_name'=>'admin']);
        Permission::create(['name'=>'Delete-Expense_Type', 'guard_name'=>'admin']);

        Permission::create(['name'=>'Create-Wallets', 'guard_name'=>'user']);
        Permission::create(['name'=>'Read-Wallets', 'guard_name'=>'user']);
        Permission::create(['name'=>'Updata-Wallets', 'guard_name'=>'user']);
        Permission::create(['name'=>'Delete-Wallets', 'guard_name'=>'user']);

        // Permission::create(['name'=>'Create-Debits', 'guard_name'=>'user']);
        // Permission::create(['name'=>'Read-Debits', 'guard_name'=>'user']);
        // Permission::create(['name'=>'Updata-Debits', 'guard_name'=>'user']);
        // Permission::create(['name'=>'Delete-Debits', 'guard_name'=>'user']);

        // Permission::create(['name'=>'Create-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Read-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Updata-', 'guard_name'=>'admin']);
        // Permission::create(['name'=>'Delete-', 'guard_name'=>'admin']);
    }
}
