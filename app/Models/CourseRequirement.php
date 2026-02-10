<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'min_jamb_score',
        'min_post_utme_score',
        'min_olevel_credits',
        'max_olevel_sittings',
        'additional_requirements',
    ];

    protected $casts = [
        'min_jamb_score' => 'integer',
        'min_post_utme_score' => 'integer',
        'min_olevel_credits' => 'integer',
        'max_olevel_sittings' => 'integer',
    ];

    /**
     * Get the course that owns this requirement
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}



