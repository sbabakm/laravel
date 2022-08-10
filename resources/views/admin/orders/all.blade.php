@component('admin.layouts.content' , ['title' => 'لیست سفارشات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست سفارشات</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.orders.create') }}">ایجاد سفارش</a>
        <form action="">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>

    <table id="example2" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
            <tr>
                <th>آیدی</th>
                <th>نام کاربر</th>
                <th>تاریخ ثبت</th>
                <th>قیمت کل</th>
                <th>وضعیت</th>
                <th>کد رهگیری پستی</th>
                <th>اقدامات</th>
            </tr>
        </thead>
        <tbody>

        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ jdate($order->created_at)->format('%d %B %y') }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->tracking_serial ?? 'هنوز ثبت نشده' }}</td>
                <td class="d-flex">
                    <form action="{{ route('admin.orders.destroy' , $order) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>

                    <a href="{{ route('admin.orders.edit' , $order) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>

                    <a href="{{ route('admin.order.payments' , $order) }}" class="btn btn-sm btn-warning mr-1">مشاهده پرداخت ها</a>

                    <a href="{{ route('admin.order.details' , $order) }}" class="btn btn-sm btn-success mr-1">جزییات سفارش</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="card-footer">--}}
{{--        {{ $orders->render() }}--}}
{{--    </div>--}}
    <div class="d-flex justify-content-center">
        {{ $orders->links("pagination::bootstrap-4") }}
    </div>
@endcomponent
