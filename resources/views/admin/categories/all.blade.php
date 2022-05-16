@component('admin.layouts.content' , ['title' => 'لیست کاربران'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.users.create') }}">ایجاد کاربر جدید</a>
        <form action="">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <a class="btn btn-sm btn-warning mb-1 mr-1" href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}">کاربران مدیر</a>
    </div>

    <table id="example2" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
            <tr>
                <th>آیدی کاربر</th>
                <th>نام کاربر</th>
                <th>ایمیل</th>
                <th>وضعیت ایمیل</th>
                <th>اقدامات</th>
            </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if($user->email_verified_at)
                    <td><span class="badge badge-success">فعال</span></td>
                @else
                    <td><span class="badge badge-danger">غیرفعال</span></td>
                @endif
                <td class="d-flex">
                    {{--<a href="#" class="btn btn-sm btn-danger">حذف</a>--}}
                    <form action="{{ route('admin.users.destroy' , $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>
                    @can('edit', $user)
                        <a href="{{ route('admin.users.edit' , $user) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="card-footer">--}}
{{--        {{ $users->render() }}--}}
{{--    </div>--}}
    <div class="d-flex justify-content-center">
        {{$users->links("pagination::bootstrap-4") }}
    </div>
@endcomponent
