<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'upload design']);

        $adminRole = Role::create(['name' => 'admin']);
        $designerRole = Role::create(['name' => 'designer']);
        $customerRole = Role::create(['name' => 'customer']);

        $designerRole->givePermissionTo('upload design');

//        $customerRole->givePermissionTo('create profile');
    }
}
