<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\Region;

class Suburb extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'district_id',
        'suburb_id',
    ];

    public function district() {
    	return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function region() {
    	return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
