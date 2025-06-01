<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{

    protected $fillable = ['province_id', 'city'];
    //
    public function province () {
        return $this->belongsTo(provinces::class, 'province_id');
    }

    public function concern () {
        return $this->hasMany(concerns::class, 'city_id');
    }

    public function users () {
        return $this->hasOne(city::class, 'city_id');
    }
}
