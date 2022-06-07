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
                    'quantity' => 2,
                    'price' => $product->price
                ],
                $product
            );
        }

        return 'ok';
    }
}
