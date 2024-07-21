<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name', 'parent_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function child(){
        return $this->hasMany(Category::class, 'parent_id')->with('child','products');
    }
    public function parent(){
        return $this->belongsTo(self::class, 'parent_id' , 'id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }
}
