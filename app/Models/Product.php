<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable=[
        'name', 'slug', 'users_id', 'price', 'description', 'categories_id'
    ];

    protected $hidden = [

    ];

    public function scopeFilters($query, array $filters){
        $query->when($filters['search'] ?? false, function($query,$search){
            return $query->where('name', 'like', '%' .$search. '%');
        });

        $query->when($filters['category'] ?? false, function($query,$category){
            $query->whereHas('category', function($query) use($category){
                return $query->where('slug', $category);
            });
        });

        $query->when($filters['user'] ?? false, function($query,$user){
            $query->whereHas('user', function($query) use($user){
                return $query->where('id', $user);
            });
        });
    }

    public function galleries(){
        return $this->hasMany(Product_gallery::class,'products_id','id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','users_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'categories_id','id');
    }
}
