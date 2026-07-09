<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsDetial extends Model
{
    use HasFactory;


        protected $fillable = [
        'product_id',
        'image',
        'image_2',
        'name',
        'source',
        'price',
        'product_type',
        'desc',
        'status',
        'created_at'
    ];

}
