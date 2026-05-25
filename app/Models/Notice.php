<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NoticeCategory;

class Notice extends Model
{
    protected $table = "notice";
    protected $fillable = ['user_id','category_id','noticetype', 'heading','content','status','views','created_at','expire_at', 'town_suburb', 'looking_for', 'job_location', 'start_date', 'budget', 'message_text'];
    public $timestamps = false;
    public function noticecategory()
    {
        return $this->belongsTo(NoticeCategory::class, 'category_id');
    }
    
}

?>