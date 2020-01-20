<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'api_token' => hash('sha256', Str::random(60))
            ],
            [
                'name' => 'Nick',
                'email' => 'nick@gmail.com',
                'password' => Hash::make('secret'),
                'api_token' => hash('sha256', Str::random(60))
            ],
        ];


        foreach ($users as $user) {
            $user = App\User::create($user);

            $user->balance()->save(new \App\Balance(['amount' => rand(20, 250)]));
        }
    }
}
