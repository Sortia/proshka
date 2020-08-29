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
        User::truncate();

        $users = [
            [
                'id' => 1,
                'name' => 'methodist',
                'email' => 'methodist@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 1,
                'email_verified_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'teacher',
                'email' => 'teacher@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 2,
                'email_verified_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'student',
                'email' => 'student@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 3,
                'email_verified_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'representative',
                'email' => 'representative@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 4,
                'email_verified_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'minor_student',
                'email' => 'minor_student@mail.ru',
                'password' => Hash::make('123'),
                'role_id' => 3,
                'representative_id' => 4,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
