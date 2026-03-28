<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Towns extends Model
{
    protected $fillable = ["city_id", "suburb_name","lat","longitude","zoom_level"];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
