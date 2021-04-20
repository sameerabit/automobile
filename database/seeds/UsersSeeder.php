<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'sameera',
            'username' => 'admin',
            'email'    => 'virajamara@gmail.com',
            'password' => Hash::make('admin'),
        ]);
    }
}
