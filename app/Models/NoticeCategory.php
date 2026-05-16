<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model
{
    protected $table = 'notice_category';
    protected $fillable = ['category', 'subtitle', 'icon', 'color', 'type', 'is_new', 'is_active'];

    /*public function country()
    {
        return $this->belongsTo(Country::class);
    }*/
    
}

?>