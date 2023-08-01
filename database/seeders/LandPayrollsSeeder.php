<?php

namespace Database\Seeders;

use App\Models\LandPayroll;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandPayrollsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('land_payrolls')->truncate();
        // NominaTierra id=3
        LandPayroll::create(['name' => 'Coordinacion General']);
        LandPayroll::create(['name' => 'Staff Estatal']);
        LandPayroll::create(['name' => 'Oficina Central']);
        LandPayroll::create(['name' => 'Juridico']);
        LandPayroll::create(['name' => 'Distritales']);
        LandPayroll::create(['name' => 'Municipales']);
        LandPayroll::create(['name' => 'Talleristas']);
        LandPayroll::create(['name' => 'Seguridad/Movilización']);
        LandPayroll::create(['name' => 'Agenda']);
        LandPayroll::create(['name' => 'Otros']);
        LandPayroll::create(['name' => 'Alerta Violeta']);
    }
}


