<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'verification_request_id',
        'candidate_name',
        'response_code',
        'response_message',
        'subjects',
        'raw_response',
        'verified_at',
    ];

    protected $casts = [
        'subjects' => 'array',
        'raw_response' => 'array',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the verification request for this result
     */
    public function verificationRequest()
    {
        return $this->belongsTo(VerificationRequest::class);
    }

    /**
     * Check if verification was successful
     */
    public function isSuccessful(): bool
    {
        return $this->response_code === 'SUCCESS';
    }
}




