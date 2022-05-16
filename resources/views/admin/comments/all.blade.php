@component('admin.layouts.content' , ['title' => 'لیست نظرات '])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست نظرات</li>
    @endslot

    <div class="d-flex">
        <form action="">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
{{--        <a class="btn btn-sm btn-warning mb-1 mr-1" href="{{ request()->fullUrlWithQuery(['approved' => 1]) }}">نظرات تایید شده</a>--}}
    </div>

    <table id="example2" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>نام کاربر</th>
                <th>نظر مدیر</th>
                <th>عنوان</th>
                <th>اقدامات</th>
            </tr>
        </thead>
        <tbody>

        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->user->name }}</td>
                @if($comment->approved)
                    <td><span class="badge badge-success">تایید</span></td>
                @else
                    <td><span class="badge badge-danger">عدم تایید</span></td>
                @endif
                <td>{{ $comment->comment }}</td>
                <td class="d-flex">
                    {{--<a href="#" class="btn btn-sm btn-danger">حذف</a>--}}
                    @can('delete-comment')
                        <form action="{{ route('admin.comments.destroy' , $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    @endcan
                    @can('edit-comment')
                        @if(!$comment->approved)
                            <form action="{{ route('admin.comments.update' , $comment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm btn-primary mr-1">تایید</button>
                            </form>
                        @endif
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
{{--        {{ $comments->links("pagination::bootstrap-4") }}--}}
        {{ $comments->withQueryString()->links("pagination::bootstrap-4") }}
{{--           {{ $comments->appends(['search' => request('search')])->links("pagination::bootstrap-4") }}--}}
    </div>
@endcomponent
