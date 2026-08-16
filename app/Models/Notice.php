<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';

    protected $fillable = ['user_id', 'category_id', 'noticetype', 'heading', 'content', 'status', 'views', 'created_at', 'expire_at', 'notice_EXPIRE', 'town_suburb', 'looking_for', 'job_location', 'start_date', 'budget', 'message_text', 'country', 'gs_address', 'gs_lat', 'gs_lng', 'gs_additional_info'];

    public $timestamps = false;

    public function noticecategory()
    {
        return $this->belongsTo(NoticeCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(NoticeImg::class, 'notice_id');
    }
}
