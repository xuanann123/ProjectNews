<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function index() {
        $data = Comment::whereNull('parent_id')->get();
        // dd($data);
        return view("admin.comments.index", compact('data'));
    }
    function destroy(Comment $comment) {
        $comment->delete();
        return back()->with('success', "Xoá bình luận thành công");
    }
}
