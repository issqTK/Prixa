<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'out_price',
        'slug',
        'meta_title',
        'meta_description',
        'user_id',
        'product_id',
        'city_id',
        'created_at'
    ];


    public function images() {
        return $this->hasMany(Image::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    /* public function setDateAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('d/m/y');
    } */
}
