@component('admin.layouts.content' , ['title' => 'ایجاد محصول'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ایجاد محصول</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.home.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">عنوان</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="عنوان را وارد کنید" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>
                            <textarea name="description" class="form-control" id="description">
                                {{ old('description') }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">قیمت</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="قیمت را وارد کنید" value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>
                            <input type="number" name="inventory" class="form-control" id="inventory" placeholder="موجودی را وارد کنید" value="{{ old('inventory') }}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت محصول</button>
                        <a href="{{ route('admin.home.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

