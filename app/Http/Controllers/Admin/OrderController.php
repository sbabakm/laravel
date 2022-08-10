<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(request()->fullUrl());
        //dd(request()->fullUrlWithQuery(['param' => 1]));
        //dd(request()->fullUrlIs('http://127.0.0.1:8000/admin/orders'));
        //dd(request()->fullUrlIs(route('admin.orders.index')));
        //dd(request()->path());
        //dd(Route::currentRouteName());
        //dd(Route::currentRouteAction());
        //dd(Route::current());

        $orders = Order::query();

        if ($search = request('search')) {
            $orders->where('id', $search)
                ->orWhere('price', $search)
                ->orWhere('status', 'LIKE', "%$search%")
                ->orWhereHas('user', function (Builder $query) use($search) {
                    $query->where('name' , 'LIKE' , $search );
                });
        }

        // request('type') is used in admin/layouts/sidebar.blade.php
        if(request('type')){
            $orders = $orders->where('status', request('type'))->orderBy('id', 'desc')->paginate(5);
        }
        else{
            $orders = $orders->orderBy('id', 'desc')->paginate(5);
        }

        //$orders = Order::orderBy('id','desc')->paginate(5);

        return view('admin.orders.all', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $statusEnums = self::getStatusEnumsFromOrderTable();

        return view('admin.orders.create' , compact('statusEnums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        //$Jalalian = '1394-11-25 15:00:00';
        //dd(\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d H:i:s', $Jalalian)->format('Y*m*d'));

        //dd(request('created_at'));
        //dd(\Morilog\Jalali\CalendarUtils::convertNumbers('۱۳۹۵-۰۲-۱۹ ۱۴:۰۴:۲۷', true));
        //dd(\Morilog\Jalali\CalendarUtils::convertNumbers(request('created_at') , true));


        //$Jalalian = '1394/11/25 15:00:00';
        // 1- convert persian string to latin string
        //$Jalalian = \Morilog\Jalali\CalendarUtils::convertNumbers(request('created_at'), true);

        //dd(\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian));//ok shod
        //dd(\Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $Jalalian));//ok shod

        // 2- convert latin string to carbon
        //$created_at = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian);//ok shod
        //$created_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $Jalalian);//ok shod

        // 3- save carbon in to database
//        Order::create([
//            'user_id' => '1',
//            'price' => '11',
//            'status' => 'unpaid',
//            'tracking_serial' => '33',
//            'created_at' => $created_at
//        ]);

        $validate_data = $request->validate([
            'user' => ['required','exists:users,id'],
            'created_at' => ['required'],
            'status' => ['required'],
            'tracking_serial' => ['required' , 'string' , 'digits:4'],
            'products' => ['array']
        ]);

        // 1- convert persian string to latin string
        $Jalalian = \Morilog\Jalali\CalendarUtils::convertNumbers(request('created_at'), true);

        // 2- convert latin string to carbon
        $created_at = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian);

        $products = collect($validate_data['products']);

        //3- compute total price
        $totalPrice = $products->sum(function($item) {
          $product = Product::find($item['productID']);
          return $product->price * $item['quantity'];
        });

        // 4- save carbon in to database - create order
       $order = Order::create([
            'user_id' => $request->user,
            'price' => $totalPrice,
            'status' => $request->status,
            'tracking_serial' => $request->tracking_serial,
            'created_at' => $created_at
        ]);

       //5- create records in order_product table جدول واسط
       $products->each(function ($item) use ($order){
           $order->products()->attach($item['productID'] , ['quantity' =>  $item['quantity']]);
       });

        return redirect(route('admin.orders.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {

        // convert latin to persian
        $tempDate = \Morilog\Jalali\CalendarUtils::strftime('Y/m/d H:i:s', strtotime($order->created_at)); // 1395-02-19
        $createdAtDefaultValue = \Morilog\Jalali\CalendarUtils::convertNumbers($tempDate); // ۱۳۹۵-۰۲-۱۹

        $statusEnums = self::getStatusEnumsFromOrderTable();
        return view('admin.orders.edit', compact('order','statusEnums','createdAtDefaultValue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //dd($request->all());

        $validate_data = $request->validate([
            'user' => ['required','exists:users,id'],
            'created_at' => ['required'],
            'status' => ['required'],
            'tracking_serial' => ['required' , 'string' , 'digits:4'],
            'products' => ['array']
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return back();
    }

    public static function getStatusEnumsFromOrderTable()
    {

        $type = DB::select(DB::raw('SHOW COLUMNS FROM orders WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;

    }

    public function viewPayments(Order $order){
        return view('admin.orders.payments', compact('order'));
    }
}
