@extends('profile.layouts')

@section('main')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table id="example2" class="table table-bordered table-hover dataTable" role="grid">
                    <thead>
                    <tr>
                        <th>آیدی سفارش</th>
                        <th>تاریخ ثبت</th>
                        <th>قیمت کل</th>
                        <th>وضعیت سفارش</th>
                        <th>کد رهگیری پستی</th>
                        <th>اقدامات</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{  jdate($order->created_at )->format('%d %B %y') }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->tracking_serial ?? 'هنوز ثبت نشده' }}</td>

                            <td class="d-flex">
                                <a href="{{ route('profile.orders.details', $order) }}" class="btn btn-sm btn-primary mr-1">مشاهده جزییات</a>
                                @if($order->status == 'unpaid')
                                    <a href="{{ route('profile.orders.payment', $order) }}" class="btn btn-sm btn-warning mr-1">پرداخت سفارش</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $orders->links("pagination::bootstrap-4") }}
                </div>

            </div>
        </div>
    </div>
@endsection
