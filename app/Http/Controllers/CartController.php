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
            Cart::update($product);
        }

        return 'ok';
    }
    public function showCart() {
        return view('home.cart');
    }
}
