<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class government_feedback extends Model
{
    protected $fillable = ['user_id', 'rating', 'feedback'];
    //
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }
}
