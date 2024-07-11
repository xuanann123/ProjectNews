<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PageController extends Controller
{
    const PATH_VIEW = "admin.pages.";
    function index(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $list_act = [
            'delete' => "Xoá toàn bộ",
            'active' => "Đăng toàn bộ",
            'pending' => "Chờ duyệt toàn bộ",
        ];
        $status = $request->status;
        if ($status == "trash") {
            $list_act = [
                'restore' => "Khôi phục toàn bộ ",
                'forceDelete' => "Xoá vĩnh viễn toàn bộ",
            ];

            $data = Page::onlyTrashed()->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "active") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'pending' => "Chờ duyệt toàn bộ",
            ];
            $data = Page::where("is_active", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "pending") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'active' => "Đăng toàn bộ",
            ];
            $data = Page::where("is_active", 0)->where('title', 'like', "%$keyword%")->latest()->get();
        } else {
            $data = Page::query()->where('title', 'like', "%$keyword%")->get();
        }
        $count = [];
        $count_all = Page::all()->count();
        $count_active = Page::where("is_active", "1")->count();
        $count_pending = Page::where("is_active", "0")->count();
        $count_trash = Page::onlyTrashed()->count();
        $count = [$count_all, $count_active, $count_pending, $count_trash];
        #NOTIFICATION COMMENT
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'list_act'));
    }
    function create()
    {
        $listUser = User::query()->get();
        #NOTIFICATION COMMENT
        return view(self::PATH_VIEW . __FUNCTION__, compact('listUser'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'is_active' => 'nullable|boolean',
                'user_id' => 'required|exists:users,id',
            ],
            [
                'required' => ":attribute không dược để trống!",
                'exists' => ":attribute phải là thành viên",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'is_active' => 'Trạng thái',
                'user_id' => 'Người tạo',
            ]
        );

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->input('is_active') ?? "0";
        Page::query()->create($data);

        return redirect()->route("admin.pages.index")->with('success', "Thêm page thành công");
    }
    function edit(Page $page)
    {
        $listUser = User::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('listUser', 'page'));
    }
    function update(Request $request, Page $page)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'is_active' => 'nullable|boolean',
                'user_id' => 'required|exists:users,id',
            ],
            [
                'required' => ":attribute không dược để trống!",
                'exists' => ":attribute phải là thành viên",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'is_active' => 'Trạng thái',
                'user_id' => 'Người tạo',
            ]
        );
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->input('is_active') ?? "0";
        $page->update($data);
        return redirect()->route("admin.pages.index")->with('success', "Sửa page thành công");
    }
    function destroy(Page $page)
    {
        //update is_acitve = 0
        $page->update([
            "is_active" => 0,
        ]);
        $page->delete();
        return redirect()->route("admin.pages.index")->with('success', "Xoá slide thành công");
    }
    function action(Request $request)
    {
        $list_check = $request->list_check;
        if ($list_check) {

            $act = $request->act;
            if ($act) {
                //pending, delete, active
                if ($act == "delete") {
                    Page::whereIn("id", $list_check)->update(["is_active" => 0]);
                    Page::destroy($list_check);
                    return redirect()->route("admin.pages.index")->with('success', 'Xoá thành công toàn bộ bản ghi đã chọn');
                }
                if ($act == "active") {
                    Page::whereIn("id", $list_check)->update(["is_active" => 1]);
                    return redirect()->route("admin.pages.index")->with('success', 'Đăng toàn bộ những bản ghi đã chọn');
                }
                if ($act == "pending") {
                    Page::whereIn("id", $list_check)->update(["is_active" => 0]);
                    return redirect()->route("admin.pages.index")->with('success', 'Chuyển đổi toàn bộ những bài viết về chờ xác nhận');
                }
                if ($act == "restore") {
                    Page::onlyTrashed()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.pages.index")->with('success', 'Khôi phục thành công toàn bộ bản ghi');
                }
                if ($act == "forceDelete") {
                    foreach ($list_check as $id) {
                        $page = Page::onlyTrashed()->findOrFail($id);
                        $page->forceDelete();
                    }
                    return redirect()->route("admin.pages.index")->with('success', 'Xoá vĩnh viễn toàn bộ bản ghi khỏi hệ thống');
                }
            } else {
                return redirect()->route("admin.pages.index")->with('error', 'Vui lòng chọn hành động để thao tác');
            }

        } else {
            return redirect()->route("admin.pages.index")->with('error', 'Vui lòng chọn trang cần thao tác');
        }
    }
    function forceDelete($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route("admin.pages.index")->with('success', 'Xoá vĩnh viễn bản ghi ra khỏi hệ thống');
    }
    function restore($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route("admin.pages.index")->with('success', 'Bạn đã khôi phục thành công trang');
    }
}
