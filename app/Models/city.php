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
}
