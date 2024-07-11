<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    const PATH_VIEW = "admin.categories.";
    function list(Request $request)
    {
        $list_act = [
            'delete' => "Xoá toàn bộ",
            'active' => "Đăng toàn bộ",
            'pending' => "Chờ duyệt toàn bộ",
        ];
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $status = $request->status;
        if ($status == "trash") {
            $list_act = [
                'restore' => "Khôi phục toàn bộ ",
                'forceDelete' => "Xoá vĩnh viễn toàn bộ",
            ];
            $data = Category::onlyTrashed()->where('name', 'like', "%$keyword%")->where('parent_id', 0)->latest()->paginate(5);
        } elseif ($status == "active") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'pending' => "Chờ duyệt toàn bộ",
            ];
            $data = Category::where("is_active", 1)->where('name', 'like', "%$keyword%")->where('parent_id', 0)->latest()->paginate(5);
        } elseif ($status == "pending") {
            $list_act = [
                'delete' => "Xoá toàn bộ",
                'active' => "Đăng toàn bộ",
            ];
            $data = Category::where("is_active", 0)->where('name', 'like', "%$keyword%")->where('parent_id', 0)->latest()->paginate(5);
        } else {
            $data = Category::where('name', 'like', "%$keyword%")->where('parent_id', 0)->latest()->paginate(5);
        }
        // dd($data);
        $count = [];
        $count_all_category = Category::all()->count();
        $count_active = Category::where("is_active", 1)->count();
        $count_peding = Category::where("is_active", 0)->count();
        $count_trash = Category::onlyTrashed()->count();
        $count = [$count_all_category, $count_active, $count_peding, $count_trash];
        
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'list_act'));
    }
    function create()
    {
        //Thực hiện Eager Loading tránh n+1 query và tối ưu hoá
        $listCategory = Category::with('childrenRecursive')->where('parent_id', '0')->get();
        //toàn bộ những thằng có danh mục cha ra ngoài
        
        return view(self::PATH_VIEW . __FUNCTION__, compact('listCategory'));
    }
    function store(Request $request)
    {

        $request->validate(
            [
                'name' => "required"
            ],
            [
                'required' => 'Vui lòng điền vào :attribute',
                'unique' => "Không được trùng :attribute với nhau"
            ],
            [
                'name' => "Tên danh mục"
            ]
        );
        $is_active = $request->is_active ? $request->is_active : 0;
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'is_active' => $is_active,
            'parent_id' => $request->input('parent_id') ?? 0
        ]);
        return redirect()->route("admin.categories.list")->with('success', 'Thêm danh mục bài viết thành công');
    }
    function edit(Category $category, Request $request)
    {
        $listCategory = Category::with('childrenRecursive')->where('parent_id', '0')->get();
        
        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'listCategory'));
    }

    function update(Category $category, Request $request)
    {
        $request->validate(
            [
                'name' => "required",
            ],
            [
                'required' => 'Vui lòng điền vào :attribute',
                'unique' => "Không được trùng :attribute với nhau"
            ],
            [
                'name' => "tên danh mục"
            ]
        );
        $is_active = $request->is_active ? $request->is_active : 0;
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'is_active' => $is_active,
            'parent_id' => $request->input('parent_id') ?? 0
        ]);
        return redirect()->route("admin.categories.list")->with('success', "Sửa danh mục thành công");

    }
    function destroy(Category $category)
    {
        $category->update([
            'is_active' => 0
        ]);
        //Xoá sản phẩm này đi
        $category->delete();
        return redirect()->route("admin.categories.list")->with('success', 'Xoá danh mục bài viết thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->list_check;
        if ($list_check) {

            $act = $request->act;
            if ($act) {
                //pending, delete, active
                if ($act == "delete") {
                    Category::whereIn("id", $list_check)->update(["is_active" => 0]);
                    Category::destroy($list_check);
                    return redirect()->route("admin.categories.list")->with('success', 'Xoá thành công toàn bộ bản ghi đã chọn');
                }
                if ($act == "active") {
                    Category::whereIn("id", $list_check)->update(["is_active" => 1]);
                    return redirect()->route("admin.categories.list")->with('success', 'Đăng toàn bộ những bản ghi đã chọn');
                }
                if ($act == "pending") {
                    Category::whereIn("id", $list_check)->update(["is_active" => 0]);
                    return redirect()->route("admin.categories.list")->with('success', 'Chuyển đổi toàn bộ những bài viết về chờ xác nhận');
                }
                if ($act == "restore") {
                    Category::onlyTrashed()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.categories.list")->with('success', 'Khôi phục thành công toàn bộ bản ghi');
                }
                if ($act == "forceDelete") {
                    Category::onlyTrashed()->whereIn("id", $list_check)->forceDelete();
                    return redirect()->route("admin.categories.list")->with('success', 'Xoá vĩnh viễn toàn bộ bản ghi khỏi hệ thống');
                }
            } else {
                return redirect()->route("admin.categories.list")->with('error', 'Vui lòng chọn hành động để thao tác');
            }

        } else {
            return redirect()->route("admin.categories.list")->with('error', 'Vui lòng chọn danh mục cần thao tác');
        }
    }
    function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route("admin.categories.list")->with('success', 'Xoá vĩnh viễn bản ghi ra khỏi hệ thống');
    }
    function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route("admin.categories.list")->with('success', 'Bạn đã khôi phục thành công danh mục');
    }
}
