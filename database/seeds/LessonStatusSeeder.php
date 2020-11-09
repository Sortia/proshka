<?php

use App\Models\LessonStatus;
use Illuminate\Database\Seeder;

class LessonStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LessonStatus::truncate();

        $roles = [
            [
                'id' => 1,
                'name' => 'Working',
            ],
            [
                'id' => 2,
                'name' => 'Edited',
            ],
            [
                'id' => 3,
                'name' => 'Draft',
            ],
            [
                'id' => 4,
                'name' => 'Archival',
            ],
        ];

        foreach ($roles as $role) {
            LessonStatus::create($role);
        }
    }
}
