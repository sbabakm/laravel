@component('admin.layouts.content' , ['title' => 'لیست اجازه دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست اجازه دسترسی</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.permissions.create') }}">ایجاد اجازه دسترسی جدید</a>
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
                <th>نام</th>
                <th>توضیحات</th>
                <th>اقدامات</th>
            </tr>
        </thead>
        <tbody>

        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->label }}</td>
                <td class="d-flex">
                    <form action="{{ route('admin.permissions.destroy' , $permission) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>

                    <a href="{{ route('admin.permissions.edit' , $permission) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="card-footer">--}}
{{--        {{ $permissions->render() }}--}}
{{--    </div>--}}
    <div class="d-flex justify-content-center">
        {{$permissions->links("pagination::bootstrap-4") }}
    </div>
@endcomponent
