<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Methodist',
            ],
            [
                'id' => 2,
                'name' => 'Teacher',
            ],
            [
                'id' => 3,
                'name' => 'Student',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
