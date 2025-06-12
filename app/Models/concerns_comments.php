<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\concerns;

class concerns_comments extends Model
{

    protected $table = 'concerns_comments';

    protected $fillable = ['comments', 'concerns_id', 'user_id'];
    //
    public function concern () {
        return $this->belongsTo(concerns::class, 'concerns_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
