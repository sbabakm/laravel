<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Product $product)
    {

        if(! Cart::has($product)) {
            Cart::put(
                [
                    'quantity' => 1,
                    //'price' => $product->price
                ],
                $product
            );
        }
        else {
            if(Cart::count($product) < $product->inventory) {
                Cart::update($product , 1);
            }
        }

        return 'ok';
    }
    public function showCart() {
        return view('home.cart');
    }
}
