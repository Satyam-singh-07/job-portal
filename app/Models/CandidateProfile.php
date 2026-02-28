<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'phone',
        'location',
        'preferred_locations',
        'portfolio_url',
        'experience_level',
        'current_company',
        'notice_period',
        'desired_employment_type',
        'salary_expectation',
        'work_preference',
        'target_roles',
        'skills',
        'social_links',
        'resume',
        'is_searchable',
        'is_public_link_active',
        'is_indexed_by_search_engines',
    ];

    protected $casts = [
        'skills' => 'array',
        'social_links' => 'array',
        'is_searchable' => 'boolean',
        'is_public_link_active' => 'boolean',
        'is_indexed_by_search_engines' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
