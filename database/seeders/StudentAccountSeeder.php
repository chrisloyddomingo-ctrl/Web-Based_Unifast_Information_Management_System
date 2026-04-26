<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentAccountSeeder extends Seeder
{
    /**
     * Seed test student accounts into student_accounts.
     */
    public function run(): void
    {
        $students = [
            [
                'student_id'       => 'STU001',
                'name'             => 'Juan dela Cruz',
                'email'            => 'student1@unifast.com',
                'password'         => Hash::make('Student@1234'),
                'course'           => 'Bachelor of Science in Information Technology',
                'year_level'       => '2nd Year',
                'is_temp_password' => false,
            ],
            [
                'student_id'       => 'STU002',
                'name'             => 'Maria Santos',
                'email'            => 'student2@unifast.com',
                'password'         => Hash::make('Student@1234'),
                'course'           => 'Bachelor of Science in Education',
                'year_level'       => '3rd Year',
                'is_temp_password' => false,
            ],
            [
                'student_id'       => 'STU003',
                'name'             => 'Jose Reyes',
                'email'            => 'student3@unifast.com',
                'password'         => Hash::make('Student@1234'),
                'course'           => 'Bachelor of Science in Nursing',
                'year_level'       => '1st Year',
                'is_temp_password' => false,
            ],
            [
                'student_id'       => 'STU004',
                'name'             => 'Ana Gonzales',
                'email'            => 'student4@unifast.com',
                'password'         => Hash::make('Student@1234'),
                'course'           => 'Bachelor of Science in Accountancy',
                'year_level'       => '4th Year',
                'is_temp_password' => false,
            ],
            [
                'student_id'       => 'STU005',
                'name'             => 'Pedro Villanueva',
                'email'            => 'student5@unifast.com',
                'password'         => Hash::make('Student@1234'),
                'course'           => 'Bachelor of Science in Engineering',
                'year_level'       => '2nd Year',
                'is_temp_password' => false,
            ],
        ];

        foreach ($students as $student) {
            DB::table('student_accounts')->insert(array_merge($student, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
