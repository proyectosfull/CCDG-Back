<?php

namespace Database\Seeders;

use App\Models\SubcostCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(ConceptAssetsSeeder::class);
        $this->call(CostCentersSeeder::class);
        $this->call(ExpenseConceptsSeeder::class);
        $this->call(SubcostCentersSeeder::class);
        $this->call(LandPayrollsSeeder::class);
        //For testing
        $this->call(UsersSeeder::class);
    }
}
