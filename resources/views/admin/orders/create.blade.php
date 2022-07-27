@component('admin.layouts.content' , ['title' => 'ایجاد سفارش'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">لیست سفارش</a></li>
        <li class="breadcrumb-item active">ایجاد سفارش</li>
    @endslot

    @slot('script')
        <script>

            $('#user').select2({
                'placeholder' : 'کاربر مورد نظر را انتخاب کنید'
            });

            $(document).ready(function() {
                $(".created_at").pDatepicker();
                //$('.created_at').persianDatepicker();

            });

        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد سفارش</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام کاربر</label>
                            <select name="user" class="form-control" id="user">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value=""></option>
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">تاریخ ثبت</label>
                            <input type="text" name="created_at" class="form-control created_at" id="created_at">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">قیمت کل</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">وضعیت</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">کد رهگیری پستی</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">محصولات</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت سفارش</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

