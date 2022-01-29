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
            'contacts' => '{}',
            'email' => 'kunaevanton25@gmail.com',
            'password' => Hash::make('kantbor0895'),
            'is_admin' => true,
        ]
        );

        DB::table('users')->insert([

            'name' => 'Егор',
            'contacts' => '{}',
            'email' => 'egorkunaev@gmail.com',
            'about' => 'Занимаюсь изучением рынка мобильных и других гаджетов. Делаю обзоры и тестирование фитнес-браслетов. Составляю рейтинги и пишу статьи для нескольких профильных сайтов.',
            'password' => Hash::make('egor12345'),
            'is_admin' => true,
        ]
        );
    }
}
