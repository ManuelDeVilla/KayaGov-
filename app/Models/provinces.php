<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    //
    public function cities () {
        return $this->hasMany(city::class, 'province_id');
    }
}
