@component('admin.layouts.content' , ['title' => 'ویرایش گروه دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست گروه دسترسی</a></li>
        <li class="breadcrumb-item active">ویرایش گروه دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش گروه دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.roles.update' , $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" id="name" placeholder="نام را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">توضیحات</label>
                            <input type="text" name="label" class="form-control" value="{{ old('label', $role->label) }}" id="label" placeholder="توضیحات را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">دسترسی ها</label>
                            <select name="permissions[]" class="form-control" multiple>
                                @foreach(\App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش گروه دسترسی</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

