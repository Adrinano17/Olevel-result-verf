<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUtmeResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jamb_result_id',
        'post_utme_reg_number',
        'post_utme_score',
        'exam_year',
        'course_id',
        'verified_at',
        'ip_address',
    ];

    protected $casts = [
        'post_utme_score' => 'integer',
        'exam_year' => 'integer',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns this Post-UTME result
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the JAMB result associated with this Post-UTME
     */
    public function jambResult()
    {
        return $this->belongsTo(JambResult::class);
    }

    /**
     * Get the course for this Post-UTME
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get admission validations for this Post-UTME result
     */
    public function admissionValidations()
    {
        return $this->hasMany(AdmissionValidation::class);
    }
}



