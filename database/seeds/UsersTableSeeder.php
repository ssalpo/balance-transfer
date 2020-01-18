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
        $users = [
            [
                'name' => 'Gosha',
                'email' => 'gosha@gmail.com',
                'password' => Hash::make('secret'),
            ],
            [
                'name' => 'Nick',
                'email' => 'nick@gmail.com',
                'password' => Hash::make('secret'),
            ],
        ];


        foreach ($users as $user) {
            $user = App\User::create($user);

            $user->balance()->save(new \App\Balance(['amount' => rand(20, 250)]));
        }
    }
}
