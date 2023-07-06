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

        $administrator = Role::create(['name' => 'administrador']);
        $operator = Role::create(['name' => 'operador']);

        /**
         * CRUDS
         */
        //Catalogs
        Permission::create(['name' => 'catalog.index'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'catalog.store'])->syncRoles([$administrator]);
        Permission::create(['name' => 'catalog.show'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'catalog.update'])->syncRoles([$administrator]);
        Permission::create(['name' => 'catalog.destroy'])->syncRoles([$administrator]);
        //SubCatalogs
        Permission::create(['name' => 'subcatalog.index'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'subcatalog.store'])->syncRoles([$administrator]);
        Permission::create(['name' => 'subcatalog.show'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'subcatalog.update'])->syncRoles([$administrator]);
        Permission::create(['name' => 'subcatalog.destroy'])->syncRoles([$administrator]);
        //user
        Permission::create(['name' => 'user.index'])->syncRoles([$administrator]);
        Permission::create(['name' => 'user.store'])->syncRoles([$administrator]);
        Permission::create(['name' => 'user.show'])->syncRoles([$administrator]);
        Permission::create(['name' => 'user.update'])->syncRoles([$administrator]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$administrator]);
        //expense
        Permission::create(['name' => 'expense.index'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'expense.store'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'expense.show'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'expense.update'])->syncRoles([$administrator, $operator]);
        Permission::create(['name' => 'expense.destroy'])->syncRoles([$administrator, $operator]);
    }
}
