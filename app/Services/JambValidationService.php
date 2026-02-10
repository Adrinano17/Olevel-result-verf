<?php

namespace App\Services;

use App\Models\JambResult;
use App\Models\Course;
use Illuminate\Support\Collection;

class JambValidationService
{
    /**
     * Validate JAMB result against course requirements
     */
    public function validate(JambResult $jambResult, Course $course): array
    {
        $details = [];
        $valid = true;
        $errors = [];

        // Check JAMB score
        if ($jambResult->jamb_score < $course->jamb_cutoff) {
            $valid = false;
            $errors[] = "JAMB score {$jambResult->jamb_score} is below required cutoff of {$course->jamb_cutoff}";
        }

        $details['score_check'] = [
            'passed' => $jambResult->jamb_score >= $course->jamb_cutoff,
            'score' => $jambResult->jamb_score,
            'required' => $course->jamb_cutoff,
        ];

        // Check JAMB subjects
        $requiredSubjects = $course->jambSubjects()
            ->where('is_required', true)
            ->orderBy('priority')
            ->pluck('subject_name')
            ->toArray();

        $jambSubjects = collect($jambResult->subjects ?? [])
            ->pluck('subject')
            ->map(fn($s) => ucwords(strtolower($s)))
            ->toArray();

        $missingSubjects = array_diff(
            array_map('strtolower', $requiredSubjects),
            array_map('strtolower', $jambSubjects)
        );

        if (!empty($missingSubjects)) {
            $valid = false;
            $errors[] = "Missing required JAMB subjects: " . implode(', ', array_map('ucwords', $missingSubjects));
        }

        $details['subjects_check'] = [
            'passed' => empty($missingSubjects),
            'required' => $requiredSubjects,
            'provided' => $jambSubjects,
            'missing' => array_map('ucwords', $missingSubjects),
        ];

        // Check if course is in choices
        $courseInChoices = in_array($course->id, [
            $jambResult->first_choice_course_id,
            $jambResult->second_choice_course_id,
            $jambResult->third_choice_course_id,
        ]);

        if (!$courseInChoices) {
            $valid = false;
            $errors[] = "Selected course '{$course->name}' was not in your JAMB course choices";
        }

        $details['course_choice_check'] = [
            'passed' => $courseInChoices,
            'first_choice' => $jambResult->firstChoiceCourse?->name,
            'second_choice' => $jambResult->secondChoiceCourse?->name,
            'third_choice' => $jambResult->thirdChoiceCourse?->name,
        ];

        $details['valid'] = $valid;
        $details['errors'] = $errors;
        $details['summary'] = $valid 
            ? "JAMB validation passed. Score and subjects meet requirements."
            : "JAMB validation failed: " . implode('; ', $errors);

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
}



