<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query();

        if ($search = request('search')) {
            $orders->where('id', $search)
                ->orWhere('price', $search)
                ->orWhere('status', 'LIKE', "%$search%")
                ->orWhereHas('user', function (Builder $query) use($search) {
                    $query->where('name' , 'LIKE' , $search );
                });
        }

        $orders = $orders->orderBy('id', 'desc')->paginate(5);
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
        dd($request->all());

        //$Jalalian = '1394-11-25 15:00:00';
        //dd(\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d H:i:s', $Jalalian)->format('Y*m*d'));

        //dd(request('created_at'));
        //dd(\Morilog\Jalali\CalendarUtils::convertNumbers('۱۳۹۵-۰۲-۱۹ ۱۴:۰۴:۲۷', true));
        //dd(\Morilog\Jalali\CalendarUtils::convertNumbers(request('created_at') , true));


        //$Jalalian = '1394/11/25 15:00:00';
        // 1- convert persian string to latin string
        $Jalalian = \Morilog\Jalali\CalendarUtils::convertNumbers(request('created_at'), true);

        //dd(\Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian));//ok shod
        //dd(\Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $Jalalian));//ok shod

        // 2- convert latin string to carbon
        $created_at = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $Jalalian);//ok shod
        //$created_at = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', $Jalalian);//ok shod

        // 3- save carbon in to database
//        Order::create([
//            'user_id' => '1',
//            'price' => '11',
//            'status' => 'unpaid',
//            'tracking_serial' => '33',
//            'created_at' => $created_at
//        ]);


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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
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
}
