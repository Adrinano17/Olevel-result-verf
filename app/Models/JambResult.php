<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JambResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jamb_reg_number',
        'jamb_score',
        'exam_year',
        'subjects',
        'first_choice_course_id',
        'second_choice_course_id',
        'third_choice_course_id',
        'verified_at',
        'ip_address',
    ];

    protected $casts = [
        'jamb_score' => 'integer',
        'subjects' => 'array',
        'exam_year' => 'integer',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns this JAMB result
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get first choice course
     */
    public function firstChoiceCourse()
    {
        return $this->belongsTo(Course::class, 'first_choice_course_id');
    }

    /**
     * Get second choice course
     */
    public function secondChoiceCourse()
    {
        return $this->belongsTo(Course::class, 'second_choice_course_id');
    }

    /**
     * Get third choice course
     */
    public function thirdChoiceCourse()
    {
        return $this->belongsTo(Course::class, 'third_choice_course_id');
    }

    /**
     * Get Post-UTME results for this JAMB result
     */
    public function postUtmeResults()
    {
        return $this->hasMany(PostUtmeResult::class);
    }

    /**
     * Get admission validations for this JAMB result
     */
    public function admissionValidations()
    {
        return $this->hasMany(AdmissionValidation::class);
    }
}



