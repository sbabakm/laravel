@component('admin.layouts.content' , ['title' => 'لیست محصولات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست محصولات</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.products.create') }}">ایجاد محصول</a>
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
                <th>ایجاد کننده</th>
                <th>عنوان</th>
                <th>توضیحات</th>
                <th>قیمت</th>
                <th>موجودی</th>
                <th>تعداد بازدید</th>
                <th>اقدامات</th>
            </tr>
        </thead>
        <tbody>

        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->user->name }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->inventory }}</td>
                <td>{{ $product->view_count }}</td>
                <td class="d-flex">
                    <form action="{{ route('admin.products.destroy' , $product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
{{--                    @can('edit-product')--}}
{{--                        <a href="{{ route('admin.products.edit' , $product) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>--}}
{{--                    @endcan--}}
                    <a href="{{ route('admin.products.edit' , $product) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="card-footer">--}}
{{--        {{ $products->render() }}--}}
{{--    </div>--}}
    <div class="d-flex justify-content-center">
        {{ $products->withQueryString()->links("pagination::bootstrap-4") }}
{{--        {{ $products->appends(['search' => request('search')])->links("pagination::bootstrap-4") }}--}}
    </div>

    <div class="btn btn-success">{{ $products->lastPage() }}</div>
    <div class="btn btn-success">{{ $products->firstItem() }}</div>
    <div class="btn btn-success">{{ $products->lastItem() }}</div>
    <div class="btn btn-success">{{ $products->nextPageUrl() }}</div>
    <div class="btn btn-success">{{ $products->perPage() }}</div>
    <div class="btn btn-success">{{ $products->total() }}</div>
    <div class="btn btn-success">{{ $products->count() }}</div>
    <div class="btn btn-success">{{ $products->url(2) }}</div>
    <div class="btn btn-success">{{ $products->url($products->lastPage()) }}</div>
    @foreach($products->items() as $item)
        <div>{{ $item->id }}</div>
    @endforeach
@endcomponent
