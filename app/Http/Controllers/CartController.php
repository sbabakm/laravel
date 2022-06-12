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

    public function quantityChange(Request $request) {

        //Cart::update($request['cart_id'] , $request['quantity']);
        $data = $request->validate([
            'quantity' => 'required',
            'id' => 'required',
//           'cart' => 'required'
        ]);

        if( Cart::has($data['id']) ) {
            Cart::update($data['id'] , [
                'quantity' => $data['quantity']
            ]);

            return response(['status' => 'success']);
        }

        return response(['status' => 'error'] , 404);
    }

    public function deleteItemFromCart($id) {

        if(Cart::has($id)) {

            Cart::delete($id);

            return back();

        }

    }

}
