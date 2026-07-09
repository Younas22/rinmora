<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $table = 'order';
    protected $fillable = [
        'order_id',
        'user_id',
        'created_by',
        'product_name',
        'order_type',
        'payment_option',
        'screen_shoot',
        'desc',
        'document',
        'total_cost',
        'payment_status',
        'order_status',
        'created_at'
    ];
}
