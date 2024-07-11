<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index(Request $request)
    {
        #Thống kế , Tổng bài viết, Tổng danh mục, Tổng quản trị, Tổng thành viên
        $listPost = Post::query()->get();
        $count_all_post = Post::query()->where('is_active', 1)->get()->count();
        $count_all_comment = Comment::query()->get()->count();
        $count_all_admin = User::query()->where('type', User::TYPE_ADMIN)->get()->count();
        $count_all_member = User::query()->get()->count();
        $count = [];
        $count = [$count_all_post, $count_all_comment, $count_all_admin, $count_all_member];
        // Lấy 6 ngày trước đây là thời gian bắt đầu
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        // Lấy ngày hiện tại
        $endDate = Carbon::now()->endOfDay();
        // Tạo mảng chứa các ngày từ startDate đến endDate
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dates[$currentDate->format('Y-m-d')] = 0; // Khởi tạo giá trị ban đầu là 0
            $currentDate->addDay();
        }
        #COMMENT => THỐNG KÊ
        // Lấy dữ liệu tổng lượt comment của các bài viết theo từng ngày trong khoảng thời gian này
        $comments = Comment::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuyển đổi dữ liệu thành định dạng mong muốn
        $commentData = $dates; // Bắt đầu với mảng các ngày đã khởi tạo
        foreach ($comments as $comment) {
            $commentData[$comment->date] = $comment->count;
        }
        #VIEW => THỐNG KÊ
        // Lấy dữ liệu tổng lượt xem theo từng ngày trong khoảng thời gian này
        $views = PostView::select(DB::raw('DATE(view_date) as date'), DB::raw('SUM(views) as total_views'))
            ->whereBetween('view_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chuyển đổi dữ liệu thành định dạng mong muốn
        $viewData = $dates; // Bắt đầu với mảng các ngày đã khởi tạo
        foreach ($views as $view) {
            $viewData[$view->date] = $view->total_views;
        }

        // Tách mảng viewData thành 2 mảng riêng biệt: dates và views
        $categoryView = array_keys($viewData);
        $countView = array_values($viewData);
        // dd($countView);

        $count_all_comment = Comment::all()->count();
        #Số lượng views
        $count_all_view = 0;
        foreach ($listPost as $post) {
            foreach ($post->views as $view) {
                $count_all_view += $view->views;
            }
        }
        // Tách mảng commentData thành 2 mảng riêng biệt: dates và counts
        $categoryComment = array_keys($commentData);
        $countComment = array_values($commentData);
        // dd($countComment);
        return view('admin.dashboard', compact('count', 'count_all_view', 'categoryComment', 'countComment', 'categoryView', 'countView', 'count_all_comment'));
    }
    function isRead(Request $request)
    {
        $list_notification_check = $request->input('list_notification_check');
        CommentNotification::whereIn('id', $list_notification_check)->update(['is_read' => true]);
        return back()->with('success', "Đánh dấu những bản ghi đã đọc");
    }
    function isWatched(Request $request)
    {
        $list_notification_check = $request->input('list_notification_check');
        ContactMessage::whereIn('id', $list_notification_check)->update(['is_read' => true]);
        return back()->with('success', "Đánh dấu những bản ghi đã đọc");
    }
}
