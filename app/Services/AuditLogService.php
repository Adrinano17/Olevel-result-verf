<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    /**
     * Log an action
     */
    public function log(
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?string $description = null,
        ?array $requestData = null,
        ?array $responseData = null
    ): AuditLog {
        $request = request();

        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $requestData,
            'response_data' => $responseData,
        ]);
    }

    /**
     * Log verification request
     */
    public function logVerificationRequest(
        int $requestId,
        array $requestData,
        array $responseData
    ): AuditLog {
        return $this->log(
            'verification_request',
            VerificationRequest::class,
            $requestId,
            'Result verification request processed',
            $requestData,
            $responseData
        );
    }

    /**
     * Log API call
     */
    public function logApiCall(
        string $endpoint,
        array $requestData,
        array $responseData
    ): AuditLog {
        return $this->log(
            'api_call',
            null,
            null,
            "API call to {$endpoint}",
            $requestData,
            $responseData
        );
    }
}




