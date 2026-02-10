<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'name',
        'code',
        'description',
        'jamb_cutoff',
        'post_utme_cutoff',
        'duration_years',
        'is_active',
    ];

    protected $casts = [
        'jamb_cutoff' => 'integer',
        'post_utme_cutoff' => 'integer',
        'duration_years' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the faculty that owns this course
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get course requirements
     */
    public function requirements()
    {
        return $this->hasOne(CourseRequirement::class);
    }

    /**
     * Get required JAMB subjects
     */
    public function jambSubjects()
    {
        return $this->hasMany(CourseJambSubject::class);
    }

    /**
     * Get required O-Level subjects
     */
    public function olevelSubjects()
    {
        return $this->hasMany(CourseOlevelSubject::class);
    }

    /**
     * Get JAMB results for this course
     */
    public function jambResults()
    {
        return $this->hasMany(JambResult::class, 'first_choice_course_id')
            ->orWhere('second_choice_course_id', $this->id)
            ->orWhere('third_choice_course_id', $this->id);
    }

    /**
     * Get admission validations for this course
     */
    public function admissionValidations()
    {
        return $this->hasMany(AdmissionValidation::class);
    }
}



