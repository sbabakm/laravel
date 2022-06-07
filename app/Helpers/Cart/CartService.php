<?php


namespace App\Helpers\Cart;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
        //dd('test when constructor call');
    }


    public function put(array $value , $obj = null)
    {
        if(! is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value , [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        } else {
            $value = array_merge($value , [
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'] , $value);//put is collection method
        session()->put('cart' , $this->cart);//put is session method

        return $this;
    }

    public function has($key) {

        if($key instanceof Model) {
           return  $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first();
        }
        return  $this->cart->where('id' , $key)->first();

    }

    public function get($key) {

        if($key instanceof Model) {
            $item = $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first();
//            $item['product'] = [
//                $key->toArray()
//            ];
            $item['product'] = [
                'title' => $key->title,
                'price' => $key->price,
                'inventory' => $key->inventory,
            ];
            return $item;
        }

        return  $this->cart->where('id' , $key)->first();
    }

    public function all() {
       // return $this->cart;
        $result = $this->cart->map(function ($item, $key) {
            if(isset($item['subject_id']) && isset($item['subject_type'])) {
                $product = Product::find($item['subject_id']);
                $item['product'] = [
                    'title' => $product->title,
                    'price' => $product->price,
                    'inventory' => $product->inventory,
                ];
            }
            return $item;
        });

        return $result;
    }

}
