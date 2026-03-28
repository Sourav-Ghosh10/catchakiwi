<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Business;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = ['title','title_url','parent_id','icon','created_on','modified_on','views'];

    /*public function country()
    {
        return $this->belongsTo(Country::class);
    }*/
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('title');
    }
    public function businesses()
    {
        return $this->hasMany(Business::class, 'secondary_category');
    }
    public function parent_businesses()
    {
        return $this->hasMany(Business::class, 'primary_category');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Get child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Check if this is a parent category
    public function isParent()
    {
        return $this->parent_id == 0;
    }

    // Get businesses using this category
    public function businessesPrimary()
    {
        return $this->hasMany(\App\Models\Business::class, 'primary_category');
    }

    public function businessesSecondary()
    {
        return $this->hasMany(\App\Models\Business::class, 'secondary_category');
    }
}

?>