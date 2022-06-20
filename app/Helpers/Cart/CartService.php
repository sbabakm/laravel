<?php


namespace App\Helpers\Cart;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    protected $name = 'default';

    public function __construct()
    {
        //$this->cart = session()->get('cart') ?? collect([]);
        //$this->cart = session()->get($this->name) ?? collect([]);
        $this->cart = collect(json_decode(request()->cookie($this->name) , true))  ?? collect([]);

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
        } elseif(! isset($value['id'])) {
            $value = array_merge($value , [
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'] , $value);//put is collection method
        //session()->put('cart' , $this->cart);//put is session method
        //session()->put($this->name , $this->cart);//put is session method

        //cookie()->queue(cookie($this->name , $this->cart->toJson() , 60));
        Cookie::queue($this->name , $this->cart->toJson() , 60);

        return $this;
    }

//    public function update($key) {
//
//        if($key instanceof Model) {
//
//          $item = $this->get($key);
//          if($item['quantity'] < $item['product']->inventory) {
//
//              $item['quantity']++;
//              $this->cart->put($item['id'] , $item);//put is collection method
//
//              session()->put('cart' , $this->cart);//put is session method
//
//          }
//
//        }
//        else {
//
//        }
//
//    }

    public function update($key , $options)
    {
        $item = collect($this->get($key, false));

        if(is_numeric($options)) {

            $item = $item->merge([
                'quantity' => $item['quantity'] + $options
            ]);

        }

        if(is_array($options)) {
            $item = $item->merge($options);
        }

        $this->put($item->toArray());

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
        }
        else {
            $item = $this->cart->where('id' , $key)->first();
        }

        return $this->withRelationshipIfExist($item);
    }

    public function all() {

        $result = $this->cart->map(function ($item, $key) {
            return $this->withRelationshipIfExist($item);
        });

        return $result;
    }

    public function withRelationshipIfExist($item) {

        if(isset($item['subject_id']) && isset($item['subject_type'])) {

            $class = $item['subject_type'];
            $subject = (new $class())->find($item['subject_id']);

            //unset($item['subject_id']);
            //unset($item['subject_type']);

            $item[strtolower(class_basename($class))] = $subject;


        }
        return $item;
    }

    public function count($key) {

        if(! $this->has($key) ) return 0;

        return $this->get($key)['quantity'];
    }

    public function delete($id) {

        $this->cart = $this->cart->filter(function ($value, $key) use ($id){
            return $value['id'] != $id;
        });

        //session()->put('cart' , $this->cart);//put is session method
        //session()->put($this->name , $this->cart);//put is session method

        //cookie()->queue(cookie($this->name , $this->cart->toJson() , 60));
        Cookie::queue($this->name , $this->cart->toJson() , 60);

    }

    public function flush() {
        $this->cart = collect([]);
        Cookie::queue($this->name , $this->cart->toJson() , 60);
        return $this;
    }

    public function instance($name) {
        //$this->cart = session()->get($name) ?? collect([]);
        $this->cart = collect(json_decode(request()->cookie($name) , true))  ?? collect([]);
        $this->name = $name;
        return $this;
    }

}
