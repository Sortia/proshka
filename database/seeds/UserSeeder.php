<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User::truncate();

        $users = [
            [
                'id' => 1,
                'name' => 'methodist',
                'email' => 'methodist@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'teacher',
                'email' => 'teacher@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 2,
            ],
            [
                'id' => 3,
                'name' => 'student',
                'email' => 'student@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 3,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
