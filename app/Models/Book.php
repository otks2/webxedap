<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_description',
        'product_author',
        'product_price',
        'product_image_url',
    ];
}
