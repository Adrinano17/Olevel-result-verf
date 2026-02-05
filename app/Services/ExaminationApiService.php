<?php

namespace App\Services;

use App\Http\Controllers\MockApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ExaminationApiService
{
    /**
     * Verify result with WAEC API
     */
    public function verifyWaec(string $examNumber, int $year, string $resultType): array
    {
        $apiUrl = config('services.waec.api_url');
        $apiKey = config('services.waec.api_key');
        $timeout = config('services.api_timeout', 30);

        // If it's a local mock API, call it directly
        if ($this->isLocalMockApi($apiUrl)) {
            return $this->callMockApiDirectly('waec', $examNumber, $year, $resultType, $apiKey);
        }

        return $this->makeRequest($apiUrl, $apiKey, [
            'exam_number' => $examNumber,
            'year' => $year,
            'result_type' => $resultType,
        ], $timeout);
    }

    /**
     * Verify result with NECO API
     */
    public function verifyNeco(string $examNumber, int $year, string $resultType): array
    {
        $apiUrl = config('services.neco.api_url');
        $apiKey = config('services.neco.api_key');
        $timeout = config('services.api_timeout', 30);

        // If it's a local mock API, call it directly
        if ($this->isLocalMockApi($apiUrl)) {
            return $this->callMockApiDirectly('neco', $examNumber, $year, $resultType, $apiKey);
        }

        return $this->makeRequest($apiUrl, $apiKey, [
            'exam_number' => $examNumber,
            'year' => $year,
            'result_type' => $resultType,
        ], $timeout);
    }

    /**
     * Check if the API URL is a local mock API
     */
    protected function isLocalMockApi(string $url): bool
    {
        return str_contains($url, 'localhost') || 
               str_contains($url, '127.0.0.1') || 
               str_contains($url, '/api/mock/');
    }

    /**
     * Call mock API directly without HTTP request
     */
    protected function callMockApiDirectly(string $type, string $examNumber, int $year, string $resultType, string $apiKey): array
    {
        try {
            $mockController = new MockApiController();
            
            // Create a mock request
            $request = Request::create('/api/mock/' . $type, 'POST', [
                'exam_number' => $examNumber,
                'year' => $year,
                'result_type' => $resultType,
            ]);
            
            // Set Authorization header
            $request->headers->set('Authorization', 'Bearer ' . $apiKey);
            
            // Call the controller method
            if ($type === 'waec') {
                $response = $mockController->waec($request);
            } else {
                $response = $mockController->neco($request);
            }
            
            // Get the JSON content from the response
            $responseData = json_decode($response->getContent(), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response from mock API');
            }
            
            return [
                'success' => $responseData['success'] ?? false,
                'code' => $responseData['code'] ?? 'UNKNOWN',
                'message' => $responseData['message'] ?? 'Unknown response',
                'data' => $responseData['data'] ?? null,
            ];
            
        } catch (Exception $e) {
            Log::error('Mock API Direct Call Error', [
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'code' => 'EXCEPTION',
                'message' => 'An error occurred while verifying the result: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Make HTTP request to examination API
     */
    protected function makeRequest(string $url, string $apiKey, array $data, int $timeout): array
    {
        try {
            // Set a connection timeout as well to prevent hanging
            $response = Http::timeout($timeout)
                ->connectTimeout(5) // Connection timeout of 5 seconds
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $data);

            // Handle timeout (408 status)
            if ($response->status() === 408) {
                return [
                    'success' => false,
                    'code' => 'TIMEOUT',
                    'message' => 'Request timeout. Please try again later.',
                    'data' => null,
                ];
            }

            // Handle HTTP errors
            if ($response->failed()) {
                return [
                    'success' => false,
                    'code' => 'API_ERROR',
                    'message' => 'API request failed: ' . $response->body(),
                    'data' => null,
                ];
            }

            $responseData = $response->json();

            return [
                'success' => $responseData['success'] ?? false,
                'code' => $responseData['code'] ?? 'UNKNOWN',
                'message' => $responseData['message'] ?? 'Unknown response',
                'data' => $responseData['data'] ?? null,
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Handle connection timeout
            Log::error('Examination API Connection Error', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'code' => 'TIMEOUT',
                'message' => 'Connection timeout. Please try again later.',
                'data' => null,
            ];
        } catch (Exception $e) {
            Log::error('Examination API Error', [
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'code' => 'EXCEPTION',
                'message' => 'An error occurred while verifying the result: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}


