<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
   public function check(Request $request){

      $validated_data = $request->validate([
           'discount' => 'required|exists:discounts,code',
           'cart' => 'required'
       ]);

       if(! auth()->check()){
           return back()->withErrors([
               'discount' => 'باید لاگین بکنید'
           ]);
       }

      $discount = Discount::whereCode($validated_data['discount'])->first();


       if($discount->expired_at < now()){
           return back()->withErrors([
               'discount' => 'اعتبار کد تمام شده است'
           ]);
       }

       if(! in_array(auth()->user()->id , $discount->users->pluck('id')->toArray())){
           return back()->withErrors([
               'discount' => 'کد مربوطه برای یوزر شما معتبر نمی باشد'
           ]);
       }

       dd('ok');

   }
}
