<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert
        (
            [
                ['area_id' => 1, 'username' => 'admin', 'password' => '$2a$12$5CqqKbUEpyx6ZPAvm2jFRuenaCvAkSovfMzSIs09cBKUX.w7NEeFu','name' => 'Juan','last_name' => 'Donquis','ci' => '30847627','charge' => 'Desarrollador','type_user_id' => '1']
        
            ]
        );
    }
}
