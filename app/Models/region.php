<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    //
    public function province ()
    {
        return $this->hasMany(provinces::class, 'region_id');
    }
}
