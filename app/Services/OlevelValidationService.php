<?php

namespace App\Services;

use App\Models\Course;
use App\Models\VerificationResult;
use Illuminate\Support\Collection;

class OlevelValidationService
{
    /**
     * Validate O-Level result against course requirements
     */
    public function validate(VerificationResult $olevelResult, Course $course): array
    {
        $details = [];
        $valid = true;
        $errors = [];

        // Get required O-Level subjects
        $requiredSubjects = $course->olevelSubjects()
            ->where('is_required', true)
            ->get();

        $olevelSubjects = collect($olevelResult->subjects ?? []);

        // Check each required subject
        $subjectChecks = [];
        foreach ($requiredSubjects as $required) {
            $subject = $olevelSubjects->first(function ($s) use ($required) {
                return strtolower($s['subject'] ?? '') === strtolower($required->subject_name);
            });

            if (!$subject) {
                $valid = false;
                $errors[] = "Missing required O-Level subject: {$required->subject_name}";
                $subjectChecks[] = [
                    'subject' => $required->subject_name,
                    'status' => 'missing',
                    'required_grade' => $required->min_grade,
                ];
                continue;
            }

            $grade = $subject['grade'] ?? '';
            $gradePassed = $this->isGradeAcceptable($grade, $required->min_grade);

            if (!$gradePassed) {
                $valid = false;
                $errors[] = "{$required->subject_name}: Grade {$grade} is below required {$required->min_grade}";
            }

            $subjectChecks[] = [
                'subject' => $required->subject_name,
                'status' => $gradePassed ? 'passed' : 'failed',
                'grade' => $grade,
                'required_grade' => $required->min_grade,
            ];
        }

        $details['subjects_check'] = $subjectChecks;

        // Check minimum credits (5 credits including Math & English)
        $credits = $olevelSubjects->filter(function ($s) {
            return $this->isCreditGrade($s['grade'] ?? '');
        })->count();

        $minCredits = $course->requirements->min_olevel_credits ?? 5;
        if ($credits < $minCredits) {
            $valid = false;
            $errors[] = "Only {$credits} credit(s), minimum {$minCredits} required";
        }

        $details['credits_check'] = [
            'passed' => $credits >= $minCredits,
            'credits' => $credits,
            'required' => $minCredits,
        ];

        // Check Math and English specifically
        $math = $olevelSubjects->first(function ($s) {
            return stripos($s['subject'] ?? '', 'mathematics') !== false;
        });
        $english = $olevelSubjects->first(function ($s) {
            return stripos($s['subject'] ?? '', 'english') !== false;
        });

        $mathPassed = $math && $this->isCreditGrade($math['grade'] ?? '');
        $englishPassed = $english && $this->isCreditGrade($english['grade'] ?? '');

        if (!$mathPassed) {
            $valid = false;
            $errors[] = "Mathematics grade does not meet credit requirement";
        }

        if (!$englishPassed) {
            $valid = false;
            $errors[] = "English Language grade does not meet credit requirement";
        }

        $details['core_subjects_check'] = [
            'mathematics' => [
                'passed' => $mathPassed,
                'grade' => $math['grade'] ?? 'N/A',
            ],
            'english' => [
                'passed' => $englishPassed,
                'grade' => $english['grade'] ?? 'N/A',
            ],
        ];

        $details['valid'] = $valid;
        $details['errors'] = $errors;
        $details['summary'] = $valid
            ? "O-Level validation passed. All required subjects and grades meet requirements."
            : "O-Level validation failed: " . implode('; ', $errors);

        return $details;
    }

    /**
     * Check if grade is acceptable (C6 or better)
     */
    private function isGradeAcceptable(string $grade, string $minGrade): bool
    {
        $gradeOrder = ['A1', 'B2', 'B3', 'C4', 'C5', 'C6', 'D7', 'E8', 'F9'];
        
        $gradeIndex = array_search(strtoupper($grade), $gradeOrder);
        $minGradeIndex = array_search(strtoupper($minGrade), $gradeOrder);

        if ($gradeIndex === false || $minGradeIndex === false) {
            return false;
        }

        return $gradeIndex <= $minGradeIndex;
    }

    /**
     * Check if grade is a credit (C6 or better)
     */
    private function isCreditGrade(string $grade): bool
    {
        $creditGrades = ['A1', 'B2', 'B3', 'C4', 'C5', 'C6'];
        return in_array(strtoupper($grade), $creditGrades);
    }
}






