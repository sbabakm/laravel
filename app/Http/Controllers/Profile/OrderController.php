<?php

namespace App\Http\Controllers\profile;

use App\Helpers\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

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

    public function payment(Order $order)
    {
            // Connect to Dargah Pardakht
            // create payment record
            // redirect to Dargah Pardakht

            $total_price = $order->price;
            $invoice = (new Invoice)->amount(1000);

            return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function($driver, $transactionId) use ($order, $invoice) {

                $order->payments()->create([
//                    'resnumber' => $invoice->getUuid(),
                    'resnumber' => $transactionId,
                ]);

            })->pay()->render();

    }

}
