<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model
{
    protected $table = 'notice_category';
    protected $fillable = ['category'];

    /*public function country()
    {
        return $this->belongsTo(Country::class);
    }*/
    
}

?>