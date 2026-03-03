<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeView extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'candidate_user_id',
        'employer_user_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_user_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_user_id');
    }
}
