<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ["name", "state_id","lat","longitude","zoom_level"];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function towns()
    {
        return $this->hasMany(Towns::class);
    }
}
