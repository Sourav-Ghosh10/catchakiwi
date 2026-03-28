<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['shortname', 'name', 'phonecode','status'];
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

?>