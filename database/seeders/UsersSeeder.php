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
        User::create(['name' => 'ccdg_presidente', 'email' => 'admin@ccdg.com', 'password' => Hash::make('accdg')])
            ->assignRole('presidente');
        User::create(['name' => 'ccdg_capturista', 'email' => 'typ@ccdg.com', 'password' => Hash::make('accdg')])
            ->assignRole('capturista');
    }
}
