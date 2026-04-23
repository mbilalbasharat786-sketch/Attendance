<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // 👈 YEH NAYI LINE ADD KI HAI

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles; // 👈 YAHAN HasRoles ADD KIYA HAI

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Agar pehle se hai toh theek hai
        'avatar', // YEH NAYI LINE ADD KAREIN
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User ki Attendances ke sath dosti (Relationship)
    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

    // User ki Leaves ke sath dosti
    public function leaves() {
        return $this->hasMany(Leave::class);
    }

    // User ke Tasks ke sath dosti
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}