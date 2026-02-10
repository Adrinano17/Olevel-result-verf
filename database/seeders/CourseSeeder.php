<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseRequirement;
use App\Models\CourseJambSubject;
use App\Models\CourseOlevelSubject;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = $this->getCoursesData();

        foreach ($courses as $courseData) {
            // Create course
            $course = Course::create([
                'faculty_id' => $courseData['faculty_id'],
                'name' => $courseData['name'],
                'code' => $courseData['code'],
                'description' => $courseData['description'] ?? null,
                'jamb_cutoff' => $courseData['jamb_cutoff'],
                'post_utme_cutoff' => $courseData['post_utme_cutoff'],
                'duration_years' => $courseData['duration_years'] ?? 4,
            ]);

            // Create course requirements
            CourseRequirement::create([
                'course_id' => $course->id,
                'min_jamb_score' => $courseData['jamb_cutoff'],
                'min_post_utme_score' => $courseData['post_utme_cutoff'],
                'min_olevel_credits' => $courseData['min_olevel_credits'] ?? 5,
                'max_olevel_sittings' => $courseData['max_olevel_sittings'] ?? 2,
            ]);

            // Create JAMB subject requirements
            foreach ($courseData['jamb_subjects'] as $index => $subject) {
                CourseJambSubject::create([
                    'course_id' => $course->id,
                    'subject_name' => $subject,
                    'is_required' => true,
                    'priority' => $index + 1,
                ]);
            }

            // Create O-Level subject requirements
            foreach ($courseData['olevel_subjects'] as $subjectData) {
                CourseOlevelSubject::create([
                    'course_id' => $course->id,
                    'subject_name' => $subjectData['name'],
                    'min_grade' => $subjectData['min_grade'] ?? 'C6',
                    'is_required' => $subjectData['required'] ?? true,
                ]);
            }
        }
    }

    private function getCoursesData(): array
    {
        return [
            // Faculty 1: Engineering (ID: 1)
            [
                'faculty_id' => 1,
                'name' => 'Computer Engineering',
                'code' => 'CEN',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'min_olevel_credits' => 5,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6', 'required' => true],
                    ['name' => 'English Language', 'min_grade' => 'C6', 'required' => true],
                    ['name' => 'Physics', 'min_grade' => 'C6', 'required' => true],
                    ['name' => 'Chemistry', 'min_grade' => 'C6', 'required' => true],
                    ['name' => 'Further Mathematics', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 1,
                'name' => 'Electrical Engineering',
                'code' => 'EEN',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 1,
                'name' => 'Mechanical Engineering',
                'code' => 'MEN',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 1,
                'name' => 'Civil Engineering',
                'code' => 'CVE',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],

            // Faculty 2: Sciences (ID: 2)
            [
                'faculty_id' => 2,
                'name' => 'Computer Science',
                'code' => 'CSC',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 2,
                'name' => 'Mathematics',
                'code' => 'MTH',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 2,
                'name' => 'Physics',
                'code' => 'PHY',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 2,
                'name' => 'Chemistry',
                'code' => 'CHM',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Physics', 'Chemistry', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                ],
            ],

            // Faculty 3: Medicine & Health Sciences (ID: 3)
            [
                'faculty_id' => 3,
                'name' => 'Medicine and Surgery',
                'code' => 'MED',
                'jamb_cutoff' => 250,
                'post_utme_cutoff' => 60,
                'jamb_subjects' => ['Biology', 'Chemistry', 'Physics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Biology', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 3,
                'name' => 'Pharmacy',
                'code' => 'PHA',
                'jamb_cutoff' => 220,
                'post_utme_cutoff' => 55,
                'jamb_subjects' => ['Biology', 'Chemistry', 'Physics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Biology', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 3,
                'name' => 'Nursing Science',
                'code' => 'NUR',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Biology', 'Chemistry', 'Physics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Biology', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 3,
                'name' => 'Medical Laboratory Science',
                'code' => 'MLS',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Biology', 'Chemistry', 'Physics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Biology', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6'],
                    ['name' => 'Physics', 'min_grade' => 'C6'],
                ],
            ],

            // Faculty 4: Social Sciences (ID: 4)
            [
                'faculty_id' => 4,
                'name' => 'Economics',
                'code' => 'ECO',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Economics', 'Government', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6'],
                    ['name' => 'Government', 'min_grade' => 'C6', 'required' => false],
                    ['name' => 'Geography', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 4,
                'name' => 'Political Science',
                'code' => 'POL',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Government', 'History', 'Economics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Government', 'min_grade' => 'C6'],
                    ['name' => 'History', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 4,
                'name' => 'Sociology',
                'code' => 'SOC',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Government', 'Economics', 'Geography', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Government', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 4,
                'name' => 'Psychology',
                'code' => 'PSY',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Biology', 'Chemistry', 'Mathematics', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Biology', 'min_grade' => 'C6'],
                    ['name' => 'Chemistry', 'min_grade' => 'C6', 'required' => false],
                ],
            ],

            // Faculty 5: Management Sciences (ID: 5)
            [
                'faculty_id' => 5,
                'name' => 'Accounting',
                'code' => 'ACC',
                'jamb_cutoff' => 200,
                'post_utme_cutoff' => 50,
                'jamb_subjects' => ['Mathematics', 'Economics', 'Accounting', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6'],
                    ['name' => 'Accounting', 'min_grade' => 'C6'],
                ],
            ],
            [
                'faculty_id' => 5,
                'name' => 'Business Administration',
                'code' => 'BAD',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Economics', 'Government', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6'],
                    ['name' => 'Commerce', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 5,
                'name' => 'Banking and Finance',
                'code' => 'BNF',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Economics', 'Accounting', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6'],
                    ['name' => 'Accounting', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
            [
                'faculty_id' => 5,
                'name' => 'Marketing',
                'code' => 'MKT',
                'jamb_cutoff' => 180,
                'post_utme_cutoff' => 45,
                'jamb_subjects' => ['Mathematics', 'Economics', 'Commerce', 'English Language'],
                'olevel_subjects' => [
                    ['name' => 'Mathematics', 'min_grade' => 'C6'],
                    ['name' => 'English Language', 'min_grade' => 'C6'],
                    ['name' => 'Economics', 'min_grade' => 'C6'],
                    ['name' => 'Commerce', 'min_grade' => 'C6', 'required' => false],
                ],
            ],
        ];
    }
}



