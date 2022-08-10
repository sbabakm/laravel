@component('admin.layouts.content' , ['title' => 'جزییات سفارش'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارشات</a></li>
        <li class="breadcrumb-item active">جزییات سفارش</li>
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
                        <th>شناسه محصول</th>
                        <th>نام محصول</th>
                        <th>قیمت محصول</th>
                        <th>تعداد سفارش</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($order->products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->pivot->quantity }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endcomponent


