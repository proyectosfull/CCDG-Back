<?php

namespace Database\Seeders;

use App\Models\ExpenseConcept;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('expense_concepts')->truncate();
        ExpenseConcept::create(['name' => 'Tierra']);
        ExpenseConcept::create(['name' => 'Nómina']);
        ExpenseConcept::create(['name' => 'Eventos']);
        ExpenseConcept::create(['name' => 'Talleres']);
        ExpenseConcept::create(['name' => 'Gasolina']);
        ExpenseConcept::create(['name' => 'Aire']);
        ExpenseConcept::create(['name' => 'Encuestas y Estudios']);
        ExpenseConcept::create(['name' => 'Entregables']);
        ExpenseConcept::create(['name' => 'Publicaciones']);
        ExpenseConcept::create(['name' => 'Milagros']);
        ExpenseConcept::create(['name' => 'Ejecutivos de Cuenta']);
        ExpenseConcept::create(['name' => 'Otros']);
    }
}
