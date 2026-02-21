<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jamb_result_id',
        'post_utme_result_id',
        'olevel_verification_id',
        'course_id',
        'validation_status',
        'jamb_valid',
        'jamb_validation_details',
        'olevel_valid',
        'olevel_validation_details',
        'post_utme_valid',
        'post_utme_validation_details',
        'overall_eligible',
        'rejection_reasons',
        'validated_at',
        'ip_address',
    ];

    protected $casts = [
        'jamb_valid' => 'boolean',
        'jamb_validation_details' => 'array',
        'olevel_valid' => 'boolean',
        'olevel_validation_details' => 'array',
        'post_utme_valid' => 'boolean',
        'post_utme_validation_details' => 'array',
        'overall_eligible' => 'boolean',
        'rejection_reasons' => 'array',
        'validated_at' => 'datetime',
    ];

    /**
     * Get the user that owns this validation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the JAMB result
     */
    public function jambResult()
    {
        return $this->belongsTo(JambResult::class);
    }

    /**
     * Get the Post-UTME result
     */
    public function postUtmeResult()
    {
        return $this->belongsTo(PostUtmeResult::class);
    }

    /**
     * Get the O-Level verification request
     */
    public function olevelVerification()
    {
        return $this->belongsTo(VerificationRequest::class, 'olevel_verification_id');
    }

    /**
     * Get the course being validated
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if validation is eligible
     */
    public function isEligible(): bool
    {
        return $this->overall_eligible === true;
    }

    /**
     * Get formatted status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->validation_status) {
            'eligible' => 'success',
            'not_eligible' => 'danger',
            'provisionally_admitted' => 'warning',
            default => 'secondary',
        };
    }
}






