<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concerns_comments extends Model
{
    protected $fillable = ['concerns_id', 'comments'];
    //
    public function concern () {
        return $this->belongsTo(concerns::class, 'concerns_id');
    }
}
