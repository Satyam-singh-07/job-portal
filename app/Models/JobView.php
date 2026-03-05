<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobView extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'viewer_key',
        'viewed_on',
    ];

    protected $casts = [
        'viewed_on' => 'date',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
