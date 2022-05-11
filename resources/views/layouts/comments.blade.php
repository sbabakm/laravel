@foreach($comments as $comment)
    <div class="card mb-3">
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

            @include('layouts.comments',['comments' => $comment->child])

        </div>
    </div>
@endforeach
