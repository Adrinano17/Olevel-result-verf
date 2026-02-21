<?php

namespace App\Services;

use App\Models\AdmissionValidation;
use App\Models\JambResult;
use App\Models\PostUtmeResult;
use App\Models\Course;
use App\Models\VerificationRequest;
use App\Models\VerificationResult;
use Illuminate\Support\Facades\Auth;

class AdmissionValidationService
{
    protected $jambValidationService;
    protected $olevelValidationService;
    protected $postUtmeValidationService;

    public function __construct(
        JambValidationService $jambValidationService,
        OlevelValidationService $olevelValidationService,
        PostUtmeValidationService $postUtmeValidationService
    ) {
        $this->jambValidationService = $jambValidationService;
        $this->olevelValidationService = $olevelValidationService;
        $this->postUtmeValidationService = $postUtmeValidationService;
    }

    /**
     * Perform comprehensive admission validation
     */
    public function validateAdmission(
        int $userId,
        int $jambResultId,
        int $olevelVerificationId,
        ?int $postUtmeResultId,
        int $courseId
    ): AdmissionValidation {
        $course = Course::findOrFail($courseId);
        $jambResult = JambResult::findOrFail($jambResultId);
        $olevelVerification = VerificationRequest::findOrFail($olevelVerificationId);
        $olevelResult = $olevelVerification->verificationResult;

        if (!$olevelResult) {
            throw new \Exception('O-Level verification result not found');
        }

        // Create validation record
        $validation = new AdmissionValidation();
        $validation->user_id = $userId;
        $validation->jamb_result_id = $jambResultId;
        $validation->olevel_verification_id = $olevelVerificationId;
        $validation->course_id = $courseId;
        $validation->ip_address = request()->ip();

        // 1. Validate JAMB
        $jambValidation = $this->jambValidationService->validate($jambResult, $course);
        $validation->jamb_valid = $jambValidation['valid'];
        $validation->jamb_validation_details = $jambValidation;

        // 2. Validate O-Level
        $olevelValidation = $this->olevelValidationService->validate($olevelResult, $course);
        $validation->olevel_valid = $olevelValidation['valid'];
        $validation->olevel_validation_details = $olevelValidation;

        // 3. Validate Post-UTME (if provided)
        if ($postUtmeResultId) {
            $postUtmeResult = PostUtmeResult::findOrFail($postUtmeResultId);
            $postUtmeValidation = $this->postUtmeValidationService->validate($postUtmeResult, $course);
            $validation->post_utme_result_id = $postUtmeResultId;
            $validation->post_utme_valid = $postUtmeValidation['valid'];
            $validation->post_utme_validation_details = $postUtmeValidation;
        } else {
            $validation->post_utme_valid = null;
            $validation->post_utme_validation_details = null;
        }

        // 4. Determine overall eligibility (Post-UTME removed)
        $validation->overall_eligible = 
            $validation->jamb_valid && 
            $validation->olevel_valid;

        // 5. Set status and rejection reasons
        if ($validation->overall_eligible) {
            $validation->validation_status = 'eligible';
            $validation->rejection_reasons = null;
        } else {
            $validation->validation_status = 'not_eligible';
            $validation->rejection_reasons = $this->getRejectionReasons($validation);
        }

        $validation->validated_at = now();
        $validation->save();

        return $validation;
    }

    /**
     * Get rejection reasons
     */
    private function getRejectionReasons(AdmissionValidation $validation): array
    {
        $reasons = [];

        if (!$validation->jamb_valid) {
            $reasons[] = [
                'category' => 'JAMB',
                'reason' => $validation->jamb_validation_details['summary'] ?? 'JAMB requirements not met',
                'details' => $validation->jamb_validation_details['errors'] ?? [],
            ];
        }

        if (!$validation->olevel_valid) {
            $reasons[] = [
                'category' => 'O-Level',
                'reason' => $validation->olevel_validation_details['summary'] ?? 'O-Level requirements not met',
                'details' => $validation->olevel_validation_details['errors'] ?? [],
            ];
        }

        if ($validation->post_utme_valid === false) {
            $reasons[] = [
                'category' => 'Post-UTME',
                'reason' => $validation->post_utme_validation_details['summary'] ?? 'Post-UTME requirements not met',
                'details' => $validation->post_utme_validation_details['errors'] ?? [],
            ];
        }

        return $reasons;
    }
}






