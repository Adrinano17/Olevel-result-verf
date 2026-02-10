<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseJambSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'subject_name',
        'is_required',
        'priority',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get the course that requires this subject
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}



