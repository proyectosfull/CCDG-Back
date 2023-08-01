<?php

namespace Database\Seeders;

use App\Models\CostCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('cost_centers')->truncate();
        CostCenter::create(['name' => 'Tierra', 'budget' => 0.0]);
        CostCenter::create(['name' => 'Aire', 'budget' => 0.0]);
        CostCenter::create(['name' => 'Administración', 'budget' => 0.0]);
        CostCenter::create(['name' => 'Milagros', 'budget' => 0.0]);
    }
}
