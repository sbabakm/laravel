<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'code',
        'expired_at'
    ];
    public function user() {

        return $this->belongsTo(User::class);

    }

    public function scopeGenerateCode($query , $user) {

        if($code = $this->getAliveCodeForUser($user)) {

           $code = $code->code;

       }

        else{

            do {
                $code = mt_rand(100000 , 999999);
            }while($this->checkCodeUnique($code , $user));

            $user->activeCode()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10)
            ]);
        }


        return $code;
    }

    private function checkCodeUnique($code , $user) {
        return !! $user->activeCode()->where('code' , $code)->first();
    }

    private function getAliveCodeForUser($user) {
        return $user->activeCode()->where('expired_at' , '>' , now())->first();
    }

    public function scopeVerifyCode($query ,$code ,$user) {
        return !! $user->activeCode()->whereCode($code)->where('expired_at' , '>' , now())->first();
    }
}
