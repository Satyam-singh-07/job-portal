<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'salary_range',
        'seniority',
        'experience',
        'open_roles',
        'visa_sponsorship',
        'summary',
        'responsibilities',
        'skills',
        'application_email',
        'external_apply_link',
        'allow_quick_apply',
        'status',
    ];

    protected $casts = [
        'visa_sponsorship' => 'boolean',
        'allow_quick_apply' => 'boolean',
        'open_roles' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            $job->slug = Str::slug($job->title) . '-' . Str::random(5);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'job_favorites')
            ->withTimestamps();
    }

    public function jobViews()
    {
        return $this->hasMany(JobView::class);
    }
}
