<?php

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
            'name' => 'Alex',
            'lastname' => 'Cordioli',
            'email' => 'alexcordioli@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'status' => 'active',
            'role' => 'admin',
            'remember_token' => \Illuminate\Support\Str::random(10)
        ]);




    }
}
