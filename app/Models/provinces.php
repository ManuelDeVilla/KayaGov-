<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    protected $fillable = ['province_initial', 'province'];
    
    public function cities () 
    {
        return $this->hasMany(city::class, 'province_id');
    }

    public function concerns() 
    {
        return $this->hasMany(concerns::class);
    }

    public function users () {
        return $this->hasOne(User::class, 'province_id');
    }
}
