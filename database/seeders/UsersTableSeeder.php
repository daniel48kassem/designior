<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id'=>'1',
            'name'=>'Daniel Kasem',
            'username'=>'daniel_kasem',
            'email'=>'daniel@gmail.com',
            'password'=>bcrypt('rootadmin'),
        ]);

        DB::table('users')->insert([
            'role_id'=>'2',
            'name'=>'Spectrum',
            'username'=>'spectrum48',
            'email'=>'author@gmail.com',
            'password'=>bcrypt('rootauthor'),
        ]);
    }
}
