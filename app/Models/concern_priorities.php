<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concern_priorities extends Model
{
    //

    protected $fillable = ['user_id', 'concern_id'];

    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function concern () {
        return $this->belongsTo(concerns::class, 'concern_id');
    }
}
