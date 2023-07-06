<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        User::create(['name' => 'ccdg_administrador', 'email' => 'admin@ccdg.com', 'password' => Hash::make('accdg')])
            ->assignRole('administrador');
        User::create(['name' => 'ccdg_operador', 'email' => 'ope@ccdg.com', 'password' => Hash::make('accdg')])
            ->assignRole('operador');
    }
}
