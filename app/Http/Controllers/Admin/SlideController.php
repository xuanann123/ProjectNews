<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\Slide;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    const PATH_VIEW = "admin.slides.";
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

            $data = Slide::onlyTrashed()->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "active") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'pending' => "Chờ duyệt toàn bộ",
            ];
            $data = Slide::where("is_active", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "pending") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'active' => "Đăng toàn bộ",
            ];
            $data = Slide::where("is_active", 0)->where('title', 'like', "%$keyword%")->latest()->get();
        } else {
            $data = Slide::query()->where('title', 'like', "%$keyword%")->get();
        }
        $count = [];
        $count_all = Slide::all()->count();
        $count_active = Slide::where("is_active", "1")->count();
        $count_pending = Slide::where("is_active", "0")->count();
        $count_trash = Slide::onlyTrashed()->count();

        $count = [$count_all, $count_active, $count_pending, $count_trash];
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'list_act'));
    }
    function create()
    {
        $listUser = User::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('listUser'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable|boolean',
                'user_id' => 'required|exists:users,id',
            ],
            [
                'required' => ":attribute không dược để trống!",
                'image' => ":attribute kiểu dữ liệu là ảnh",
                'exists' => ":attribute phải là thành viên",
            ],
            [
                'title' => 'Tiêu đề',
                'description' => 'Mô tả',
                'image' => 'Hình ảnh',
                'is_active' => 'Trạng thái',
                'user_id' => 'Người tạo',
            ]
        );

        $data = $request->except('image');
        $data['is_active'] = $request->input('is_active') ?? "0";
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('slides', $request->file('image'));
        }
        // dd($data);
        DB::beginTransaction();
        try {
            Slide::query()->create($data);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            if ($request->hasFile('image') && Storage::exit($request->file('image'))) {
                Storage::delete($request->file('image'));
            }
            throw $exception;
        }

        return redirect()->route("admin.slides.index")->with('success', "Thêm slide thành công");
    }
    function edit(Slide $slide)
    {
        $listUser = User::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('listUser', 'slide'));
    }
    function update(Slide $slide, Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable|boolean',
                'user_id' => 'required|exists:users,id',
            ],
            [
                'required' => ":attribute không dược để trống!",
                'image' => ":attribute kiểu dữ liệu là ảnh",
                'exists' => ":attribute phải là thành viên",
            ],
            [
                'title' => 'Tiêu đề',
                'description' => 'Mô tả',
                'image' => 'Hình ảnh',
                'is_active' => 'Trạng thái',
                'user_id' => 'Người tạo',
            ]
        );
        $data = $request->except('image');
        $data['is_active'] = $request->input('is_active') ?? "0";
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('slides', $request->file('image'));
        }
        // dd($data);
        $current_image = $slide->image;
        $slide->update($data);
        if ($request->hasFile('image') && $current_image && Storage::exists($current_image)) {
            Storage::delete($current_image);
        }
        return redirect()->route("admin.slides.index")->with('success', "Cập nhật slide thành công");
    }
    function destroy(Slide $slide)
    {
        //update is_acitve = 0
        $slide->update([
            "is_active" => 0,
        ]);
        $slide->delete();
        return redirect()->route("admin.slides.index")->with('success', "Xoá slide thành công");
    }
    function action(Request $request)
    {
        $list_check = $request->list_check;
        if ($list_check) {

            $act = $request->act;
            if ($act) {
                //pending, delete, active
                if ($act == "delete") {
                    Slide::whereIn("id", $list_check)->update(["is_active" => 0]);
                    Slide::destroy($list_check);
                    return redirect()->route("admin.slides.index")->with('success', 'Xoá thành công toàn bộ bản ghi đã chọn');
                }
                if ($act == "active") {
                    Slide::whereIn("id", $list_check)->update(["is_active" => 1]);
                    return redirect()->route("admin.slides.index")->with('success', 'Đăng toàn bộ những bản ghi đã chọn');
                }
                if ($act == "pending") {
                    Slide::whereIn("id", $list_check)->update(["is_active" => 0]);
                    return redirect()->route("admin.slides.index")->with('success', 'Chuyển đổi toàn bộ những bài viết về chờ xác nhận');
                }
                if ($act == "restore") {
                    Slide::onlyTrashed()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.slides.index")->with('success', 'Khôi phục thành công toàn bộ bản ghi');
                }
                if ($act == "forceDelete") {
                    foreach ($list_check as $id) {
                        $slide = Slide::onlyTrashed()->findOrFail($id);

                        $slide->forceDelete();
                        if (Storage::exists($slide->image) && $slide->image) {
                            Storage::delete($slide->image);
                        }
                    }
                    return redirect()->route("admin.slides.index")->with('success', 'Xoá vĩnh viễn toàn bộ bản ghi khỏi hệ thống');
                }
            } else {
                return redirect()->route("admin.slides.index")->with('error', 'Vui lòng chọn hành động để thao tác');
            }

        } else {
            return redirect()->route("admin.slides.index")->with('error', 'Vui lòng chọn danh mục cần thao tác');
        }
    }
    function forceDelete($id)
    {
        $slide = Slide::onlyTrashed()->findOrFail($id);
        Slide::onlyTrashed()->findOrFail($id)->forceDelete();
        if (Storage::exists($slide->image) && $slide->image) {
            Storage::delete($slide->image);
        }
        return redirect()->route("admin.slides.index")->with('success', 'Xoá vĩnh viễn bản ghi ra khỏi hệ thống');
    }
    function restore($id)
    {
        $slide = Slide::onlyTrashed()->findOrFail($id);
        $slide->restore();
        return redirect()->route("admin.slides.index")->with('success', 'Bạn đã khôi phục thành công danh mục');
    }
}
