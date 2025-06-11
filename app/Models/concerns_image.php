<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concerns_image extends Model
{
    protected $fillable = ['concerns_id', 'image_path'];
    //
    public function concern()
    {
        return $this->belongsTo(concerns::class, 'concerns_id');
    }
}
