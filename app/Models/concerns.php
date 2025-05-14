<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concerns extends Model
{
    //
    protected $fillable = ['title', 'description', 'city', 'priority', 'pending'];

    public function concern_reports () {
        return $this->hasMany(concern_report::class, 'concerns_id');
    }

    public function concern_comments () {
        return $this->hasMany(concerns_comments::class, 'concerns_id');
    }

    public function concern_images () {
        return $this->hasMany(concerns_image::class, 'concerns_id');
    }
}
