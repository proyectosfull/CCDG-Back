<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();

        $president = Role::create(['name' => 'presidente']);
        $typist = Role::create(['name' => 'capturista']);

        /**
         * CRUDS
         */
        // permisos especificos
        //state
        // Permission::create(['name' => 'state.index'])->syncRoles([$president, $typist]);
        // Permission::create(['name' => 'state.store'])->syncRoles([$president,]);
        // Permission::create(['name' => 'state.show'])->syncRoles([$president, $typist]);
        // Permission::create(['name' => 'state.update'])->syncRoles([$president,]);
        // Permission::create(['name' => 'state.destroy'])->syncRoles([$president,]);
    }
}
