<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class Redirect extends Model
{
    use HasFactory;

    public function setCodeAttribute()
    {
        $hashids = new Hashids(config('hashids.connections.main.salt'));
        $this->attributes['code'] = $hashids->encode($this->attributes['id']);
    }
}
