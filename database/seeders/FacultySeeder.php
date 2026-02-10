<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'name' => 'Faculty of Engineering',
                'code' => 'ENG',
                'description' => 'Engineering and Technology programs',
            ],
            [
                'name' => 'Faculty of Sciences',
                'code' => 'SCI',
                'description' => 'Pure and Applied Sciences',
            ],
            [
                'name' => 'Faculty of Medicine & Health Sciences',
                'code' => 'MHS',
                'description' => 'Medical and Health-related programs',
            ],
            [
                'name' => 'Faculty of Social Sciences',
                'code' => 'SSC',
                'description' => 'Social and Behavioral Sciences',
            ],
            [
                'name' => 'Faculty of Management Sciences',
                'code' => 'MGT',
                'description' => 'Business and Management programs',
            ],
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}



