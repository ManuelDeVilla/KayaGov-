<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concerns extends Model
{
    //
    protected $fillable = ['title', 'description', 'category', 'city_id', 'status', 'user_id'];

        protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];    
    public function city () {
        return $this->belongsTo(city::class, 'city_id');
    }
    public function concern_reports () {
        return $this->hasMany(concern_report::class, 'concerns_id');
    }

    public function comments () {
        return $this->hasMany(concerns_comments::class, 'concerns_id');
    }

    public function concern_images () {
        return $this->hasMany(concerns_image::class, 'concerns_id');
    }

    public function users () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function priority () {
        return $this->hasMany(concern_priorities::class, 'concern_id');
    }
}
