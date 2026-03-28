<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['admin_id', 'title', 'message', 'selected_categories', 'selected_subcategories', 'selected_users','country', 'sent_count', 'sent_at'];
    protected $casts = [
        'sent_at' => 'datetime',
        'selected_categories' => 'array',
        'selected_subcategories' => 'array',
        'selected_users' => 'array',
    ];
	public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function recipients()
    {
        return $this->belongsToMany(User::class, 'notification_user');
    }
}
?>