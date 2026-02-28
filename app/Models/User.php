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
        'email_verified',
        'username',
        'logo',
        'industry',
        'tagline',
        'summary',
        'rating',
    ];

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
    ];

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
