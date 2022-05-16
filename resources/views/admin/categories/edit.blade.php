@component('admin.layouts.content' , ['title' => 'ویرایش کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ویرایش کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.users.update' , $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">نام کاربر</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="name" placeholder="نام کاربر را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">ایمیل</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" id="email" placeholder="ایمیل را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">پسورد</label>
                            <input type="password" name="password" class="form-control"  id="password" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-sm-2 control-label">تکرار پسورد</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="verify" class="form-check-input" id="verify" @if($user->email_verified_at) checked @endif>
                            <label class="form-check-label" for="verify">اکانت فعال باشد</label>
                        </div>
                        <div class="form-group">
                            <label for="permission" class="col-sm-2 control-label">دسترسی</label>
                            <select class="form-control" name="permissions[]" multiple>
                                @foreach(\App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id , $user->permissions()->pluck('id')->toArray())  ? 'selected' : ''}}> {{ $permission->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش کاربر</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent

