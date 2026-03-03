<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPageActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path',
        'path_hash',
        'page_title',
        'activity_date',
        'total_seconds',
        'last_seen_at',
        'session_id',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'last_seen_at' => 'datetime',
        'total_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
