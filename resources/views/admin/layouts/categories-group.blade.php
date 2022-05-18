<ul class="list-group list-group-flush">
    @foreach($categories as $cate)
        <li class="list-group-item">
            <div class="d-flex">
                <span>{{ $cate->name }}</span>
                <div class="actions mr-2">
                    <form action="{{ route('admin.categories.destroy' , $cate) }}" method="POST" id="delete-category-{{ $cate->id }}-form">
                        @csrf
                        @method('delete')
                    </form>
                    <a href="#" class="badge badge-danger" onclick="document.getElementById('delete-category-{{ $cate->id }}-form').submit();">حذف</a>
                    <a href="{{ route('admin.categories.edit' , $cate) }}" class="badge badge-primary">ویرایش</a>
                    <a href="{{ route('admin.categories.create') }}?parent={{$cate->id}}" class="badge badge-warning">ثبت زیر دسته</a>
                </div>
                @if($cate->child->count())
                    @include('admin.layouts.categories-group',['categories' => $cate->child])
                @endif
            </div>
        </li>
    @endforeach

</ul>
