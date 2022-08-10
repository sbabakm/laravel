@component('admin.layouts.content' , ['title' => 'مشاهده پرداخت ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارشات</a></li>
        <li class="breadcrumb-item active">مشاهده پرداخت ها</li>
    @endslot

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div>
                    <span>
                        <span>آیدی سفارش:</span>
                        <span>{{ $order->id }}</span>
                    </span>
                    <span class="mx-3">
                        <span>تاریخ ثبت:</span>
                        <span>{{  jdate($order->created_at )->format('%d %B %y') }}</span>
                    </span>
                    <span class="mx-3">
                        <span>قیمت کل:</span>
                        <span>{{ $order->price }}</span>
                    </span>
                    <span class="mx-3">
                        <span>وضعیت سفارش:</span>
                        <span>{{ $order->status }}</span>
                    </span>
                </div>
                <table id="example2" class="table table-bordered table-hover dataTable" role="grid">
                    <thead>
                    <tr>
                        <th>شماره فاکتور</th>
                        <th>وضعیت پرداخت</th>
                        <th>تاریخ پرداخت</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($order->payments as $payment)
                        <tr>
                            <td>{{ $payment->resnumber }}</td>

{{--                            @if($payment->status == 0)--}}
{{--                                <td>ناموفق</td>--}}
{{--                            @endif--}}
{{--                            @if($payment->status == 1)--}}
{{--                                <td>موفق</td>--}}
{{--                            @endif--}}

                            <td>{{ $payment->status ? 'موفق' : 'ناموفق' }}</td>

                            <td>{{ jdate($payment->created_at)->format('%d %B %y') }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endcomponent

