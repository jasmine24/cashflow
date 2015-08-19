<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use App\User;

class SeedUsersTableTableSeeder extends Seeder
{
    public function run()
    {
        {
            DB::table('users')->truncate();

            $users = [
                [
                    'first_name' => 'Emily',
                    'last_name' => 'Thorn',
                    'email' => 'emily.thorn@gmail.com',
                    'password' => Hash::make('emilythorn')
                ],
                [
                    'first_name' => 'Fred',
                    'last_name' => 'Jackson',
                    'email' => 'fred.jackson@gmail.com',
                    'password' => Hash::make('fredjackson')
                ],
            ];

            foreach($users as $user){
                User::create($user);
            }
        }
    }
}
