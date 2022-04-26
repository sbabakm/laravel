@component('admin.layouts.content' , ['title' => 'ایجاد اجازه دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست اجازه دسترسی</a></li>
        <li class="breadcrumb-item active">ایجاد اجازه دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد اجازه دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">توضیحات</label>
                            <input type="text" name="label" class="form-control" id="label" placeholder="توضیحات را وارد کنید" value="{{ old('label') }}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت کاربر</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

