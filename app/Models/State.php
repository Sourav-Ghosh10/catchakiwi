<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ["name", "country_id","lat","longitude","zoom_level"];  

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function towns()
    {
        return $this->hasMany(Towns::class);
    }
}
