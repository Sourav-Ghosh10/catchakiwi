<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessReview;

class Business extends Model
{
    use HasFactory;

    protected $table = 'business';
    protected $fillable = [
        'user_id',
        'homebased_business',
        'slug',
        'map',
        'suits_you',
        'company_name',
        'display_name',
        'primary_category',
        'secondary_category',
        'business_description',
        'contact_person',
        'email_address',
        'country',
        'main_phone',
        'website_url',
        'secondary_phone',
        'address',
        'region',
        'select_image',
        'street',
        'town_suburb',
        'postal_code',
        'city_or_district',
        'apartment_number',
        'display_address',
        'facebook',
        'linkedIn',
        'twitter',
        'created_at',  // Now fillable
        'updated_at',  // Now fillable
        'status',
      	'view_count'
    ];
    public function reviews()
    {
        return $this->hasMany(BusinessReview::class, 'business_id');
    }
    public function user()
      {
          return $this->belongsTo(User::class);
      }

      public function primaryCategory()
      {
          return $this->belongsTo(Category::class, 'primary_category');
      }

      public function secondaryCategory()
      {
          return $this->belongsTo(Category::class, 'secondary_category');
      }
}