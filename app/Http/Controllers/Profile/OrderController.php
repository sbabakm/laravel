<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index(){
        $orders = auth()->user()->orders()->paginate(10);
        return view('profile.orders-list', compact('orders'));
    }

    public function showDetails(Order $order){
        //dd($order->products[0]->pivot->quantity);

        if(Gate::allows('view', $order)) {
            return view('profile.order-detail', compact('order'));
        }
        abort(403);

    }

}
