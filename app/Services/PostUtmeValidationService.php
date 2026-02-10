<?php

namespace App\Services;

use App\Models\PostUtmeResult;
use App\Models\Course;

class PostUtmeValidationService
{
    /**
     * Validate Post-UTME result against course requirements
     */
    public function validate(PostUtmeResult $postUtmeResult, Course $course): array
    {
        $details = [];
        $valid = true;
        $errors = [];

        // Check Post-UTME score
        if ($postUtmeResult->post_utme_score < $course->post_utme_cutoff) {
            $valid = false;
            $errors[] = "Post-UTME score {$postUtmeResult->post_utme_score} is below required cutoff of {$course->post_utme_cutoff}";
        }

        $details['score_check'] = [
            'passed' => $postUtmeResult->post_utme_score >= $course->post_utme_cutoff,
            'score' => $postUtmeResult->post_utme_score,
            'required' => $course->post_utme_cutoff,
        ];

        // Check if Post-UTME course matches JAMB course choice
        $jambResult = $postUtmeResult->jambResult;
        $courseInChoices = in_array($course->id, [
            $jambResult->first_choice_course_id,
            $jambResult->second_choice_course_id,
            $jambResult->third_choice_course_id,
        ]);

        if (!$courseInChoices) {
            $valid = false;
            $errors[] = "Post-UTME course '{$course->name}' does not match any JAMB course choice";
        }

        $details['course_match_check'] = [
            'passed' => $courseInChoices,
            'post_utme_course' => $course->name,
        ];

        $details['valid'] = $valid;
        $details['errors'] = $errors;
        $details['summary'] = $valid
            ? "Post-UTME validation passed. Score meets requirements."
            : "Post-UTME validation failed: " . implode('; ', $errors);

        return $details;
    }
}



