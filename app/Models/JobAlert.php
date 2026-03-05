<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobAlert extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'role_keywords',
        'locations',
        'job_type',
        'frequency',
        'min_salary',
        'delivery_channel',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_salary' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
