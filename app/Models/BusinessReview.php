<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessReview extends Model
{
    use HasFactory;

    // Define the table name if it's not the default (plural of the model name)
    protected $table = 'business_review';

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'business_id',
        'rating',
        'initial_rate',
        'value_rate',
        'quality_rate',
        'cleanliness_rate',
        'punctuality_rate',
        'overall_opinion_rate',
        'user_id',
        'status',
        'review',
    ];

    // Disable the automatic timestamps if not needed
    public $timestamps = true;

    // Define any relationships if applicable
    // For example, if the review belongs to a business, you can add:
    // public function business() {
    //     return $this->belongsTo(Business::class);
    // }
}
