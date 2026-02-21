<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'address',
        'state_of_origin',
        'local_government_area',
        'nationality',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_address',
        'next_of_kin_relationship',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_address',
        'emergency_contact_relationship',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        $names = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $names) ?: $this->user->name ?? 'N/A';
    }
}
