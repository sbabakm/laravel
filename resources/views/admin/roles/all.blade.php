@component('admin.layouts.content' , ['title' => 'لیست گروه های دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست گروه های دسترسی</li>
    @endslot

    <div class="d-flex">
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('admin.roles.create') }}">ایجاد گروه دسترسی جدید</a>
{{--        <a class="btn btn-sm btn-success mb-1 ml-1" href="/babak/mahsa/neda">تست</a>--}}
{{--        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('bbk', ['javad','iman']) }}">تست</a>--}}
        <a class="btn btn-sm btn-success mb-1 ml-1" href="{{ route('bbk', ['x' => 'farzad' , 'z' => 'milad']) }}">تست</a>
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

        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->label }}</td>
                <td class="d-flex">
                    <form action="{{ route('admin.roles.destroy' , $role) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">حذف</button>
                    </form>

                    {{--  <a href="/admin/roles/{{ $role->id }}/edit" class="btn btn-sm btn-primary mr-1">ویرایش</a>  --}}
                    <a href="{{ route('admin.roles.edit' , $role) }}" class="btn btn-sm btn-primary mr-1">ویرایش</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    <div class="card-footer">--}}
{{--        {{ $roles->render() }}--}}
{{--    </div>--}}
    <div class="d-flex justify-content-center">
        {{$roles->links("pagination::bootstrap-4") }}
    </div>
@endcomponent
