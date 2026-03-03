<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'website',
        'team_size',
        'email',
        'password',
        'role_id',
        'desired_role',
        'otp_code',
        'otp_expires_at',
        'otp_attempts',
        'otp_locked_until',
        'otp_last_sent_at',
        'email_verified',
        'username',
        'logo',
        'industry',
        'tagline',
        'summary',
        'rating',
        'account_status',
        'job_posting_balance',
        'job_application_balance',
    ];

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expires_at' => 'datetime',
        'otp_locked_until' => 'datetime',
        'otp_last_sent_at' => 'datetime',
        'otp_attempts' => 'integer',
        'email_verified' => 'boolean',
        'rating' => 'decimal:2',
        'job_posting_balance' => 'integer',
        'job_application_balance' => 'integer',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function jobAlerts()
    {
        return $this->hasMany(JobAlert::class);
    }

    public function favoriteJobs()
    {
        return $this->belongsToMany(Job::class, 'job_favorites')
            ->withTimestamps();
    }

    public function candidateConversations()
    {
        return $this->hasMany(Conversation::class, 'candidate_user_id');
    }

    public function employerConversations()
    {
        return $this->hasMany(Conversation::class, 'employer_user_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_user_id');
    }

    public function followingEmployers()
    {
        return $this->belongsToMany(
            User::class,
            'employer_followers',
            'candidate_user_id',
            'employer_user_id'
        )->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'employer_followers',
            'employer_user_id',
            'candidate_user_id'
        )->withTimestamps();
    }

    public function pageActivities()
    {
        return $this->hasMany(UserPageActivity::class);
    }

    public static function findByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    public function isEmployer()
    {
        return $this->role?->name === 'employer';
    }

    public function isCandidate()
    {
        return $this->role?->name === 'candidate';
    }

    public function isSuspended(): bool
    {
        return (string) ($this->account_status ?? 'Active') === 'Suspended';
    }

    public function hasJobPostingCredits(): bool
    {
        return (int) ($this->job_posting_balance ?? 0) > 0;
    }

    public function hasJobApplicationCredits(): bool
    {
        return (int) ($this->job_application_balance ?? 0) > 0;
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && Storage::exists($this->logo)) {
            return Storage::url($this->logo);
        }

        return $this->generateInitialsAvatar();
    }

    private function generateInitialsAvatar(): string
    {
        $name = $this->company_name ?? 'Company';

        $initials = collect(explode(' ', $name))
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->implode('');

        return "https://ui-avatars.com/api/?name={$initials}&background=0D6EFD&color=fff&size=300";
    }
}
