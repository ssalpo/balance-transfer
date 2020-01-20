<?php

use Illuminate\Database\Seeder;
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
                'api_token' => '$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6' //hash('sha256', Str::random(60))
            ],
            [
                'name' => 'Nick',
                'email' => 'nick@gmail.com',
                'password' => Hash::make('secret'),
                'api_token' => '$2y$10$hg8rkjA5X40VXnImnVsore7OwmT2MgVoJc8SnevWIvVnrD9WhOeku' //hash('sha256', Str::random(60))
            ],
        ];


        foreach ($users as $user) {
            $user = App\User::create($user);

            $user->balance()->save(new \App\Balance(['amount' => rand(20, 250)]));
        }
    }
}
