<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOlevelSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'subject_name',
        'min_grade',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Get the course that requires this subject
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}



