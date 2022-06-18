<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function saveOrder()
    {
        //dd(Cart::instance('roocket')->all());
        $cart = Cart::instance('roocket')->all();

        $totalPrice = $cart->sum(function ($cart) {
            return $cart['product']->price * $cart['quantity'];
        });

        $order =  auth()->user()->orders()->create([
            'price' => $totalPrice,
            'status' => 'unpaid',
        ]);

        $cart->each(function ($item, $key) use ($order) {
            $order->products()->attach($item['product']->id , ['quantity' => $item['quantity']]);
        });
    }
}
