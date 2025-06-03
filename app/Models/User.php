<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'usertype',
        'gender',
        'province_id',
        'city_id',
        'image_path'
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

    public function concern () {
        return $this->hasMany(concerns::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(city::class, 'city_id');
    }

    public function verification () {
        return $this->hasOne(user_verification::class, 'user_id');
    }

    public function province () {
        return $this->belongsTo(provinces::class, 'province_id');
    }

    public function cities () {
        return $this->belongsTo(city::class, 'city_id');
    }
}
