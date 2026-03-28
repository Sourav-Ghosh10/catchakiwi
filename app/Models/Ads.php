<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = ['ads_image', 'country', 'type', 'link', 'updated_at']; // Fillable columns

    //protected $timestamps = false; 

    //protected $primaryKey = 'id';
}

?>