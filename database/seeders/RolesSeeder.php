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

        $administracion = Role::create(['name' => 'Administración']);
        $tierra = Role::create(['name' => 'Tierra']);
        $aire = Role::create(['name' => 'Aire']);
        $milagros = Role::create(['name' => 'Milagros']);

        /**
         * CRUDS
         */
        //user
        Permission::create(['name' => 'user.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'user.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'user.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'user.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$administracion]);
        //account-status
        Permission::create(['name' => 'account-status.index'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'account-status.store'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'account-status.show'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'account-status.update'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'account-status.destroy'])->syncRoles([$administracion]);
        //area
        Permission::create(['name' => 'area.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'area.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'area.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'area.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'area.destroy'])->syncRoles([$administracion]);
        //concept-asset
        Permission::create(['name' => 'concept-asset.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-asset.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-asset.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-asset.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-asset.destroy'])->syncRoles([$administracion]);
        //concept-expense-by-user
        Permission::create(['name' => 'concept-expense-by-user.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-expense-by-user.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-expense-by-user.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-expense-by-user.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'concept-expense-by-user.destroy'])->syncRoles([$administracion]);
        //cost-center
        Permission::create(['name' => 'cost-center.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center.destroy'])->syncRoles([$administracion]);
        //employee
        Permission::create(['name' => 'employee.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'employee.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'employee.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'employee.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'employee.destroy'])->syncRoles([$administracion]);
        //employee-record
        Permission::create(['name' => 'employee-record.index'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'employee-record.store'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'employee-record.show'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'employee-record.update'])->syncRoles([$administracion, $tierra, $aire, $milagros]);
        Permission::create(['name' => 'employee-record.destroy'])->syncRoles([$administracion]);
        //expense-concept
        Permission::create(['name' => 'expense-concept.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'expense-concept.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'expense-concept.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'expense-concept.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'expense-concept.destroy'])->syncRoles([$administracion]);
        //subcost-center
        Permission::create(['name' => 'subcost-center.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'subcost-center.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'subcost-center.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'subcost-center.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'subcost-center.destroy'])->syncRoles([$administracion]);
        //transaction
        Permission::create(['name' => 'transaction.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'transaction.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'transaction.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'transaction.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'transaction.destroy'])->syncRoles([$administracion]);
        //land-payroll
        Permission::create(['name' => 'land-payroll.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'land-payroll.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'land-payroll.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'land-payroll.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'land-payroll.destroy'])->syncRoles([$administracion]);
        //cost-center-expense-concept
        Permission::create(['name' => 'cost-center-expense-concept.index'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center-expense-concept.store'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center-expense-concept.show'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center-expense-concept.update'])->syncRoles([$administracion]);
        Permission::create(['name' => 'cost-center-expense-concept.destroy'])->syncRoles([$administracion]);
    }
}
