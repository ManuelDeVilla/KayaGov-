<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    protected $table = 'profile_user';

    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

