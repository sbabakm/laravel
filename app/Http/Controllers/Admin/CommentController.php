<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query();
        if($keyword = request('search')) {
             $comments->where('comment','LIKE',"%{$keyword}%");
        }

        //if($keyword = request('approved')) {
        //    $comments->where('approved',1);
        //}

       //$comments = Comment::orderBy('id','desc')->paginate(10);
        $comments = $comments->where('approved',1)->orderBy('id','desc')->paginate(10);

        return view('admin.comments.all',compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'approved' => 1
        ]);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }

    public function unapprovedComments()
    {
        $comments = Comment::query();

        if($keyword = request('search')) {
            $comments->where('comment','LIKE',"%{$keyword}%");
        }

        $comments = $comments->where('approved',0)->orderBy('id','desc')->paginate(10);

        return view('admin.comments.all',compact('comments'));

    }
}
