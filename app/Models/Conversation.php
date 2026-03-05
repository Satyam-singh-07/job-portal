<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_user_id',
        'employer_user_id',
        'job_id',
        'subject',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_user_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_user_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
