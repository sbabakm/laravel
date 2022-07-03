<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = auth()->user()->orders()->paginate(10);
        return view('profile.orders-list', compact('orders'));
    }
}
