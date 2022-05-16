@component('admin.layouts.content' , ['title' => 'لیست دسته بندی ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست دسته بندی ها</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.categories.create') }}">ایجاد دسته جدید</a>
        <form action="">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="جستجو"
                       value="{{ request('search') }}">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    @include('admin.layouts.categories-group',['categories' => $categories])
{{--    <ul class="list-group list-group-flush">--}}
{{--        --}}
{{--        <li class="list-group-item">--}}
{{--            <div class="d-flex">--}}
{{--                <span>test</span>--}}
{{--                <div class="actions mr-2">--}}
{{--                    <form action="" id="" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                    </form>--}}
{{--                    <a href="#" class="badge badge-danger">حذف</a>--}}
{{--                    <a href="#" class="badge badge-primary">ویرایش</a>--}}
{{--                    <a href="#" class="badge badge-warning">ثبت زیر دسته</a>--}}
{{--                </div>--}}
{{--                <ul class="list-group list-group-flush">--}}
{{--                    <li class="list-group-item">--}}
{{--                        <div class="d-flex">--}}
{{--                            <span>test2</span>--}}
{{--                            <div class="actions mr-2">--}}
{{--                                <form action="" id="" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                </form>--}}
{{--                                <a href="#" class="badge badge-danger">حذف</a>--}}
{{--                                <a href="#" class="badge badge-primary">ویرایش</a>--}}
{{--                                <a href="#" class="badge badge-warning">ثبت زیر دسته</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li class="list-group-item">--}}
{{--                        <div class="d-flex">--}}
{{--                            <span>test2</span>--}}
{{--                            <div class="actions mr-2">--}}
{{--                                <form action="" id="" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                </form>--}}
{{--                                <a href="#" class="badge badge-danger">حذف</a>--}}
{{--                                <a href="#" class="badge badge-primary">ویرایش</a>--}}
{{--                                <a href="#" class="badge badge-warning">ثبت زیر دسته</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}

{{--        </li>--}}
{{--        --}}
{{--        @foreach($categories as $cate)--}}
{{--            <li class="list-group-item">--}}
{{--                <div class="d-flex">--}}
{{--                    <span>{{ $cate->name }}</span>--}}
{{--                    <div class="actions mr-2">--}}
{{--                        <form action="" id="" method="POST">--}}
{{--                            @csrf--}}
{{--                            @method('delete')--}}
{{--                        </form>--}}
{{--                        <a href="#" class="badge badge-danger">حذف</a>--}}
{{--                        <a href="#" class="badge badge-primary">ویرایش</a>--}}
{{--                        <a href="#" class="badge badge-warning">ثبت زیر دسته</a>--}}
{{--                    </div>--}}
{{--                    @if($cate->child->count())--}}
{{--                        <ul class="list-group list-group-flush">--}}
{{--                            @foreach($cate->child as $childCate)--}}
{{--                                <li class="list-group-item">--}}
{{--                                    <div class="d-flex">--}}
{{--                                        <span>{{ $childCate->name }}</span>--}}
{{--                                        <div class="actions mr-2">--}}
{{--                                            <form action="" id="" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                            </form>--}}
{{--                                            <a href="#" class="badge badge-danger">حذف</a>--}}
{{--                                            <a href="#" class="badge badge-primary">ویرایش</a>--}}
{{--                                            <a href="#" class="badge badge-warning">ثبت زیر دسته</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}

    <div class="d-flex justify-content-center">
        {{--        {{ $categories->links("pagination::bootstrap-4") }}--}}
        {{ $categories->withQueryString()->links("pagination::bootstrap-4") }}
        {{--           {{ $categories->appends(['search' => request('search')])->links("pagination::bootstrap-4") }}--}}
    </div>
@endcomponent
