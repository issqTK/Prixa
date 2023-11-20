<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'title',
        'description_header',
        'description_footer',
        'meta_title',
        'meta_description',
        'slug',
        'product_ids',
        'city_id'
    ];

    protected $casts = [
        'product_ids' => 'array'
    ];

    public function city() {
        return $this->belongsTo(City::class);
    }
}
