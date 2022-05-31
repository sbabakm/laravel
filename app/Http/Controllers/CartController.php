<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Product $product) {
        Cart::put([
            'inventory' => $product->inventory,
            'price' => $product->price
        ]);
    }
}
