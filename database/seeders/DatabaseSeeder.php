<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Антон',
            'email' => 'kunaevanton25@gmail.com',
            'password' => Hash::make('kantbor0895'),
            'is_admin' => true,
        ]);
    }
}
