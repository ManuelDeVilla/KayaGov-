<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concern_report extends Model
{
    protected $fillable = ['concerns_id', 'description'];
    //
    public function concern () {
        return $this->belongsTo(concerns::class, 'concerns_id');
    }
}
