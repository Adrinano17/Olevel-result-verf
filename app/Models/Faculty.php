<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get courses for this faculty
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get active courses only
     */
    public function activeCourses()
    {
        return $this->hasMany(Course::class)->where('is_active', true);
    }
}






