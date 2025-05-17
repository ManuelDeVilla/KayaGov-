<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    protected $fillable = ['region_id', 'province_initial', 'province'];
    
    public function region () 
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    
    public function cities () 
    {
        return $this->hasMany(city::class, 'province_id');
    }
}
