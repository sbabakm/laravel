<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment' , 'approved' , 'parent_id' , 'commentable_id' , 'commentable_type'];
    //protected $fillable = ['comment' , 'approved' , 'parent_id' , 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function commentable() {
        return $this->morphTo();
    }
}
