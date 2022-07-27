@component('admin.layouts.content' , ['title' => 'ویرایش اجازه دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">لیست اجازه دسترسی</a></li>
        <li class="breadcrumb-item active">ویرایش اجازه دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش اجازه دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.permissions.update' , $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" id="name" placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">توضیحات</label>
                            <input type="text" name="label" class="form-control" value="{{ old('label', $permission->label) }}" id="label" placeholder="توضیحات را وارد کنید">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش اجازه دسترسی</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

