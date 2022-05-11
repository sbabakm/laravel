@extends('layouts.app')

@section('script')
    <script>
        $('#sendComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            //console.log(button.data('type'));
            var button_type = button.data('type');
            var comment_id = button.data('id');
            if(button_type == 'submit-comment') {
                $("#parent_id").val(0);
            }
            if(button_type == 'reply-comment') {
                $("#parent_id").val(comment_id);
            }

            //var subject_id = button.data('id'); // Extract info from data-* attributes
            //var subject_type = button.data('type'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            //var modal = $(this)
            //modal.find('.modal-body #subject_id').val(subject_id)
            //modal.find('.modal-body #subject_type').val(subject_type)
        });


        @if (count($errors) > 0)
        $(document).ready(function () {
            $('#sendComment').modal('show');
        });
        @endif

        $("#submit").click(function () {

            var commentable_id = $("#commentable_id").val();
            var commentable_type = $("#commentable_type").val();
            var parent_id = $("#parent_id").val();
            var comment = $("#comment").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                }
            });


            $.ajax({
            url: "{{ route('send.comment') }}",
            type: 'POST',
            data: {
                commentable_id: commentable_id,
                commentable_type: commentable_type,
                parent_id: parent_id,
                comment: comment,
            },
            success: function (data) {
                $('#sendComment').modal('hide');
                $("#comment").val(null);
                location.reload();

            },
            error: function (error) {
                //console.log(error);
                $("#comment").addClass("is-invalid");
                $("#comment_error_container").text("این فیلد اجباری می باشد");

            }
        });

        });

        /*

        document.querySelector('#comment_form').addEventListener('submit' , function(event) {
            event.preventDefault();
            let target = event.target;

            let data = {
                commentable_id : target.querySelector('input[name="commentable_id"]').value,
                commentable_type: target.querySelector('input[name="commentable_type"]').value,
                parent_id: target.querySelector('input[name="parent_id"]').value,
                comment: target.querySelector('textarea[name="comment"]').value
            }

            // if(data.comment.length < 2) {
            //     console.error('pls enter comment more than 2 char');
            //     return;
            // }


            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            })


            $.ajax({
                type : 'POST',
                url : '/comments',
                data : JSON.stringify(data),
                success : function(data) {
                    console.log(data);
                }
            })
        })

        */

    </script>

@endsection

@section('content')
    @auth
        <div class="modal fade" id="sendComment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{--
                    <form action="{{ route('send.comment') }}" method="POST" id="comment_form">
                    --}}
                    <form id="comment_form">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="commentable_id" id="commentable_id" value="{{ $product->id }}">
                            <input type="hidden" name="commentable_type" id="commentable_type"
                                   value="{{ get_class($product) }}">
                            <input type="hidden" name="parent_id" id="parent_id" value="0">
                            <div class="form-group">
                                <label for="comment" class="col-form-label">پیام دیدگاه:</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"
                                          id="comment"></textarea>
                                @error('comment')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <span class="invalid-feedback" role="alert">
                                    <strong id="comment_error_container"></strong>
                                </span>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
{{--                            <button type="submit" class="btn btn-primary">ارسال نظر</button>--}}
                                <button type="button" class="btn btn-primary" id="submit">ارسال نظر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-4">بخش نظرات</h4>
                    @auth
                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="1"
                              data-type="submit-comment">ثبت نظر جدید</span>
                    @endauth

                    @guest
                        <div class="alert alert-warning"> برای ثبت نظر وارد سایت شوید </div>
                    @endguest

                </div>

                {{--

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="commenter">
                            <span>نام نظردهنده</span>
                            <span class="text-muted">- دو دقیقه قبل</span>
                        </div>
                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="2"
                              data-type="product">پاسخ به نظر</span>
                    </div>

                    <div class="card-body">
                        محصول زیبایه

                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between">
                                <div class="commenter">
                                    <span>نام نظردهنده</span>
                                    <span class="text-muted">- دو دقیقه قبل</span>
                                </div>
                            </div>

                            <div class="card-body">
                                محصول زیبایه
                            </div>
                        </div>
                    </div>
                </div>

                --}}


                @foreach($product->comments()->where('parent_id' , 0)->get() as $comment)
                {{--  @foreach($product->comments()->where('parent_id' , 0)->paginate(5) as $comment) --}}
                        <div class="card mb-3 border  {{ ! $loop->first ? 'border-danger' : 'border-primary' }}">

                                <div class="card-header d-flex justify-content-between">
                                    <div class="commenter d-flex">
                                        <span>{{ $comment->user->name }}</span>
                                        <span class="text-muted">- {{ jdate($comment->created_at)->ago() }}</span>
                                    </div>
                                    @auth
                                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="{{ $comment->id }}"
                                            data-type="reply-comment">پاسخ به نظر</span>
                                    @endauth
                                </div>

                            <div class="card-body">

                                {{ $comment->comment }}
                                {{--
                                @foreach($product->comments()->where('parent_id' , $comment->id)->get() as $childComment)
                                --}}
                                @foreach($comment->child as $childComment)
                                    <div class="card mt-3">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="commenter d-flex">
                                                <span>{{ $childComment->user->name }}</span>
                                                <span class="text-muted">- {{ jdate($childComment->created_at)->ago() }}</span>
                                            </div>
                                            @auth
                                                <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="{{ $childComment->id }}"
                                                      data-type="reply-comment">پاسخ به نظر</span>
                                            @endauth
                                        </div>

                                        <div class="card-body">
                                            {{ $childComment->comment }}
                                            {{--
                                            @foreach($product->comments()->where('parent_id' , $childComment->id)->get() as $grandChildComment)
                                                <div class="card mt-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="commenter">
                                                            <span>{{ $grandChildComment->user->name }}</span>
                                                            <span class="text-muted">- {{ $grandChildComment->created_at }}</span>
                                                        </div>
                                                        @auth
                                                            <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="{{ $grandChildComment->id }}"
                                                                  data-type="reply-comment">پاسخ به نظر</span>
                                                        @endauth
                                                    </div>

                                                    <div class="card-body">
                                                        {{ $grandChildComment->comment }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                @endforeach

            </div>
        </div>

        {{--

        <div class="d-flex justify-content-center">
            {{ $product->comments()->where('parent_id' , 0)->paginate(5)->links("pagination::bootstrap-4") }}
        </div>

        --}}

    </div>
@endsection
