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

    public function setQueryParamsAttribute($value)
    {
        $this->attributes['query_params'] = json_encode($value);
    }

    public function getParsedQueryParamsAttribute()
    {
        return json_decode($this->attributes['query_params'], true);
    }
}
