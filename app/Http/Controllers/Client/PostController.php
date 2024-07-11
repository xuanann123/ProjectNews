<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Http\Controllers\getMenu;

class PostController extends Controller
{
    //Chi tiết bài viết
    function detail($id)
    {
        $list_category_nav = $this->getMenu();
        //Trong một bài viết lấy ra những comment và từ những comment thì đi lấy ra những câu trả lời
        $post = Post::with('comments.replies')->findOrFail($id);
        $this->recordView($post);
        return view("client/post/detail", compact('list_category_nav', 'post'));
    }
    protected function recordView(Post $post)
    {
        $today = Carbon::now()->format('Y-m-d');
        // Tìm hoặc tạo mới bản ghi cho hôm nay (điều kiện tìm, giá trị mặc định start)
        $postView = PostView::firstOrCreate(
            ['post_id' => $post->id, 'view_date' => $today],
            ['views' => 0]
        );
        // Tăng số lượt xem
        $postView->increment('views');
    }
    //Lưu trữ comment
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $postId,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);
        //Thêm dữ liệu thông báo comment
        CommentNotification::create([
            'comment_id' => $comment->id,
        ]);
        return redirect()->back();
    }
    //Chi tiết bài viết nằm trong danh mục
    public function detailCategory(Category $category)
    {
        $list_category_nav = $this->getMenu();
        if (count($category->parent()->get()->toArray()) > 0) {
            $sourceCategory = $category->parent;
        } else {
            $sourceCategory = $category;
        }
        // dd($sourceCategory);
        return view("client/post/detailCategory", compact('sourceCategory', 'category', 'list_category_nav'));
    }
    function search(Request $request)
    {
        $list_category_nav = $this->getMenu();
        $keyword = "";
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $list_post_search = Post::query()->where('is_active', 1)->where('title', 'like', "%$keyword%")->get();
        // dd($list_post_search);
        return view("client/post/search", compact('list_category_nav', 'list_post_search'));
    }
}


