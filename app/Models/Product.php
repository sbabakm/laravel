<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'description' , 'price' , 'inventory' , 'view_count'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
