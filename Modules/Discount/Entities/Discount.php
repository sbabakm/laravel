<?php

namespace Modules\Discount\Entities;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['code', 'percent', 'expired_at'];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
