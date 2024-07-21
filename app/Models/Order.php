<?php

namespace App\Models;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory , Notifiable;
   // public $timestamps = false;

    protected $fillable = ['product_id', 'quantity','status','created_at','user_ip','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userByIp()
    {
        return $this->hasOne(User::class,'user_ip');
    }

     public function product()
    {
    return $this->belongsTo(Product::class,'product_id');
    }
    protected static function booted()
    {
        static::created(function ($order) {
            event(new OrderCreated($order));
        });
    }
}

