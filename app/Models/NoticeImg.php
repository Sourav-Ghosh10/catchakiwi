<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeImg extends Model
{
    protected $table = 'notice_image';
    protected $fillable = ['notice_id','img_path','created_at'];
    public $timestamps = false;
    
}

?>