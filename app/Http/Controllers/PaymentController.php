<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function payment()
    {
        //dd(Cart::instance('roocket')->all());
        //$cart = Cart::instance('roocket')->all();
        $cart = Cart::instance('roocket');
        $cartItems = $cart->all();

        if ($cartItems->count()) {

            // 1- Compute total price (sum is collection method)
            $totalPrice = $cartItems->sum(function ($cart) {
                return $cart['product']->price * $cart['quantity'];
            });

            // 2- Create order record
            $order = auth()->user()->orders()->create([
                'price' => $totalPrice,
                'status' => 'unpaid',
            ]);

            // 3- Create records in order_product table

//        $cartItems->each(function ($item, $key) use ($order) {
//            $order->products()->attach($item['product']->id , ['quantity' => $item['quantity']]);
//        });

            $orderItems = $cartItems->mapWithKeys(function ($item, $key) {
                return [$item['product']->id => ['quantity' => $item['quantity']]];
            });

            $order->products()->attach($orderItems);

            // 4- Connect to Dargah Pardakht

//            $token = config('services.payping.token');
            $res_number = Str::random();
//
//            $args = [
//                 "amount" => 1000,
//                 //"payerIdentity" => "شناسه کاربر در صورت وجود",
//                 "payerName" => auth()->user()->name,
//                 //"description" => "توضیحات",
//                 "returnUrl" => route('payment.callback'),
//                 "clientRefId" => $res_number
//            ];
//
//            $payment = new \PayPing\Payment($token);
//
//            try {
//                $payment->pay($args);
//            } catch (Exception $e) {
//                var_dump($e->getMessage());
//            }

            //echo $payment->getPayUrl();

            //header('Location: ' . $payment->getPayUrl());

            // 5- create payment record

            $order->payments()->create([
                'resnumber' => $res_number,
                'price' => $totalPrice
            ]);

            // 6- clear Sabad Kharid

            $cart->flush();

            // 7- redirect to Dargah Pardakht

//            return redirect($payment->getPayUrl());

            return 'ok';
        }

    }

    public function callback(){

    }

}
