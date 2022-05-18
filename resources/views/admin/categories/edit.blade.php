@component('admin.layouts.content' , ['title' => 'ویرایش دسته'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسته</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.categories.update' , $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام دسته</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name' , $category->name) }}" id="name">
                        </div>
                        @if($category->parent)
                            <div class="form-group">
                                <label for="parent" class="col-sm-2 control-label">دسته پدر</label>
                                <select class="form-control" name="parent">
                                    @foreach(\App\Models\Category::all() as $cate)
                                        <option value="{{ $cate->id }}" {{ $cate->id == $category->parent ? 'selected' : '' }}>{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دسته</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

