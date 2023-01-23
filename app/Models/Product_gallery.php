<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_gallery extends Model
{
    use HasFactory;

    protected $fillable=[
        'photos','products_id'
    ];

    protected $hidden = [

    ];

    public function product(){
        return $this->belongsTo(Product::class,'products_id','id');
    }
}
