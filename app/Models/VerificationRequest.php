<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_number',
        'exam_year',
        'exam_body',
        'result_type',
        'status',
        'ip_address',
    ];

    protected $casts = [
        'exam_year' => 'integer',
    ];

    /**
     * Get the user that made the request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the verification result for this request
     */
    public function verificationResult()
    {
        return $this->hasOne(VerificationResult::class);
    }

    /**
     * Scope for successful verifications
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope for failed verifications
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['failed', 'timeout']);
    }
}




