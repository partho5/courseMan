<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=20;$i++){
            \Illuminate\Support\Facades\DB::table('users')->insert([
                'name'      => 'User '.$i,
                'email'     => "user$i@gmail.com",
                'password'  => bcrypt('123456'),
            ]);
        }
    }
}
