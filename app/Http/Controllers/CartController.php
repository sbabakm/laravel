<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Product $product)
    {

        $cart = Cart::instance('roocket');//in meghdar ro dar haghighat bayad az blade begirim

        if(! $cart->has($product)) {
            $cart->put(
                [
                    'quantity' => 1,
                    //'price' => $product->price
                ],
                $product
            );
        }
        else {
            if($cart->count($product) < $product->inventory) {
                $cart->update($product , 1);
            }
        }

//        if(! Cart::has($product)) {
//            Cart::put(
//                [
//                    'quantity' => 1,
//                    //'price' => $product->price
//                ],
//                $product
//            );
//        }
//        else {
//            if(Cart::count($product) < $product->inventory) {
//                Cart::update($product , 1);
//            }
//        }

        return 'ok';
    }

    public function showCart() {
        return view('home.cart');
    }

    public function showCart2() {
        return view('home.cart2');
    }

    public function quantityChange(Request $request) {

        //Cart::update($request['cart_id'] , $request['quantity']);

        $data = $request->validate([
            'quantity' => 'required',
            'id' => 'required',
//           'cart' => 'required'
        ]);

        $cart = Cart::instance($request['cart_name']);

        if( $cart->has($data['id']) ) {
            $cart->update($data['id'] , [
                'quantity' => $data['quantity']
            ]);

//        if( Cart::has($data['id']) ) {
//            Cart::update($data['id'] , [
//                'quantity' => $data['quantity']
//            ]);

            return response(['status' => 'success']);
        }

        return response(['status' => 'error'] , 404);
    }

    public function deleteItemFromCart($id) {

        $cart = Cart::instance('roocket');//in meghdar ro dar haghighat bayad az blade begirim

        if($cart->has($id)) {

            $cart->delete($id);

            return back();

        }

//        if(Cart::has($id)) {
//
//            Cart::delete($id);
//
//            return back();
//
//        }

    }

}
