<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MockApiController extends Controller
{
    /**
     * Mock WAEC API endpoint
     */
    public function waec(Request $request)
    {
        // Validate API key
        $apiKey = $request->header('Authorization');
        if (!$apiKey || !str_starts_with($apiKey, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'code' => 'UNAUTHORIZED',
                'message' => 'Invalid or missing API key',
                'data' => null,
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'exam_number' => 'required|string',
            'year' => 'required|integer',
            'result_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 'VALIDATION_ERROR',
                'message' => 'Invalid request parameters',
                'data' => null,
            ], 400);
        }

        $examNumber = strtoupper($request->exam_number);
        $year = $request->year;
        $resultType = $request->result_type;

        // Simulate different scenarios based on exam number
        return $this->simulateResponse($examNumber, $year, $resultType, 'WAEC');
    }

    /**
     * Mock NECO API endpoint
     */
    public function neco(Request $request)
    {
        // Validate API key
        $apiKey = $request->header('Authorization');
        if (!$apiKey || !str_starts_with($apiKey, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'code' => 'UNAUTHORIZED',
                'message' => 'Invalid or missing API key',
                'data' => null,
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'exam_number' => 'required|string',
            'year' => 'required|integer',
            'result_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 'VALIDATION_ERROR',
                'message' => 'Invalid request parameters',
                'data' => null,
            ], 400);
        }

        $examNumber = strtoupper($request->exam_number);
        $year = $request->year;
        $resultType = $request->result_type;

        // Simulate different scenarios based on exam number
        return $this->simulateResponse($examNumber, $year, $resultType, 'NECO');
    }

    /**
     * Simulate API responses based on exam number patterns
     */
    protected function simulateResponse(string $examNumber, int $year, string $resultType, string $examBody): \Illuminate\Http\JsonResponse
    {
        // Simulate server error (5% chance)
        if (rand(1, 100) <= 5) {
            return response()->json([
                'success' => false,
                'code' => 'SERVER_ERROR',
                'message' => 'Internal server error. Please try again later.',
                'data' => null,
            ], 500);
        }

        // Simulate timeout (3% chance) - Return immediately without sleep to avoid PHP timeout
        if (rand(1, 100) <= 3) {
            return response()->json([
                'success' => false,
                'code' => 'TIMEOUT',
                'message' => 'Request timeout. Please try again later.',
                'data' => null,
            ], 408);
        }

        // Invalid exam number pattern
        if (str_contains($examNumber, 'INVALID') || strlen($examNumber) < 8) {
            return response()->json([
                'success' => false,
                'code' => 'INVALID_EXAM_NUMBER',
                'message' => 'Invalid exam number format',
                'data' => null,
            ], 400);
        }

        // Candidate not found pattern
        if (str_contains($examNumber, 'NOTFOUND') || str_contains($examNumber, 'NF')) {
            return response()->json([
                'success' => false,
                'code' => 'CANDIDATE_NOT_FOUND',
                'message' => 'No result found for the provided exam number',
                'data' => null,
            ], 404);
        }

        // Valid result - return mock data
        $candidateName = $this->generateMockName($examNumber);
        $subjects = $this->generateMockSubjects();

        return response()->json([
            'success' => true,
            'code' => 'SUCCESS',
            'message' => 'Result verified successfully',
            'data' => [
                'candidate_name' => $candidateName,
                'exam_number' => $examNumber,
                'exam_year' => $year,
                'exam_body' => $examBody,
                'result_type' => $resultType,
                'subjects' => $subjects,
                'total_subjects' => count($subjects),
                'verified_at' => now()->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * Generate mock candidate name based on exam number
     */
    protected function generateMockName(string $examNumber): string
    {
        $names = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Sarah Williams',
            'David Brown',
            'Emily Davis',
            'Robert Wilson',
            'Olivia Martinez',
        ];

        $index = crc32($examNumber) % count($names);
        return $names[$index];
    }

    /**
     * Generate mock subjects and grades
     */
    protected function generateMockSubjects(): array
    {
        $subjects = [
            'Mathematics',
            'English Language',
            'Physics',
            'Chemistry',
            'Biology',
            'Geography',
            'Economics',
            'Government',
            'Literature in English',
            'Further Mathematics',
        ];

        $grades = ['A1', 'B2', 'B3', 'C4', 'C5', 'C6', 'D7', 'E8', 'F9'];

        $result = [];
        $selectedSubjects = array_slice($subjects, 0, rand(6, 9));

        foreach ($selectedSubjects as $subject) {
            $result[] = [
                'subject' => $subject,
                'grade' => $grades[array_rand($grades)],
            ];
        }

        return $result;
    }

    /**
     * Mock JAMB API endpoint
     */
    public function jamb(Request $request)
    {
        // Validate API key
        $apiKey = $request->header('Authorization');
        if (!$apiKey || !str_starts_with($apiKey, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'code' => 'UNAUTHORIZED',
                'message' => 'Invalid or missing API key',
                'data' => null,
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'jamb_reg_number' => 'required|string',
            'year' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 'VALIDATION_ERROR',
                'message' => 'Invalid request parameters',
                'data' => null,
            ], 400);
        }

        $regNumber = strtoupper($request->jamb_reg_number);
        $year = $request->year;

        // Simulate different scenarios
        if (str_contains($regNumber, 'INVALID') || strlen($regNumber) < 8) {
            return response()->json([
                'success' => false,
                'code' => 'INVALID_REG_NUMBER',
                'message' => 'Invalid JAMB registration number',
                'data' => null,
            ], 400);
        }

        if (str_contains($regNumber, 'NOTFOUND') || str_contains($regNumber, 'NF')) {
            return response()->json([
                'success' => false,
                'code' => 'CANDIDATE_NOT_FOUND',
                'message' => 'No JAMB result found for the provided registration number',
                'data' => null,
            ], 404);
        }

        // Generate mock JAMB result
        $score = rand(150, 350);
        $subjects = [
            ['subject' => 'Mathematics', 'score' => rand(40, 100)],
            ['subject' => 'English Language', 'score' => rand(40, 100)],
            ['subject' => 'Physics', 'score' => rand(40, 100)],
            ['subject' => 'Chemistry', 'score' => rand(40, 100)],
        ];

        return response()->json([
            'success' => true,
            'code' => 'SUCCESS',
            'message' => 'JAMB result verified successfully',
            'data' => [
                'jamb_reg_number' => $regNumber,
                'jamb_score' => $score,
                'exam_year' => $year,
                'subjects' => $subjects,
                'verified_at' => now()->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * Mock Post-UTME API endpoint
     */
    public function postUtme(Request $request)
    {
        // Validate API key
        $apiKey = $request->header('Authorization');
        if (!$apiKey || !str_starts_with($apiKey, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'code' => 'UNAUTHORIZED',
                'message' => 'Invalid or missing API key',
                'data' => null,
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'post_utme_reg_number' => 'required|string',
            'year' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 'VALIDATION_ERROR',
                'message' => 'Invalid request parameters',
                'data' => null,
            ], 400);
        }

        $regNumber = strtoupper($request->post_utme_reg_number);
        $year = $request->year;

        // Simulate different scenarios
        if (str_contains($regNumber, 'INVALID') || strlen($regNumber) < 8) {
            return response()->json([
                'success' => false,
                'code' => 'INVALID_REG_NUMBER',
                'message' => 'Invalid Post-UTME registration number',
                'data' => null,
            ], 400);
        }

        if (str_contains($regNumber, 'NOTFOUND') || str_contains($regNumber, 'NF')) {
            return response()->json([
                'success' => false,
                'code' => 'CANDIDATE_NOT_FOUND',
                'message' => 'No Post-UTME result found for the provided registration number',
                'data' => null,
            ], 404);
        }

        // Generate mock Post-UTME result
        $score = rand(30, 100);

        return response()->json([
            'success' => true,
            'code' => 'SUCCESS',
            'message' => 'Post-UTME result verified successfully',
            'data' => [
                'post_utme_reg_number' => $regNumber,
                'post_utme_score' => $score,
                'exam_year' => $year,
                'verified_at' => now()->toIso8601String(),
            ],
        ], 200);
    }
}


