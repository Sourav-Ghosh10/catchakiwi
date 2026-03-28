<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'icon'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }
}
