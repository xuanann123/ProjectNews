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
        $listAction = [
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
            $listAction = [
                'restore' => "Khôi phục toàn bộ ",
                'forceDelete' => "Xoá vĩnh viễn toàn bộ",
            ];
            $data = Category::onlyTrashed()->where('name', 'like', "%$keyword%")->latest('id')->paginate(5);
        } elseif ($status == "active") {
            $listAction = [
                'delete' => "Xoá toàn bộ",
                'pending' => "Chờ duyệt toàn bộ",
            ];
            $data = Category::where("is_active", 1)->where('name', 'like', "%$keyword%")->latest('id')->paginate(5);
        } elseif ($status == "pending") {
            $listAction = [
                'delete' => "Xoá toàn bộ",
                'active' => "Đăng toàn bộ",
            ];
            $data = Category::where("is_active", 0)->where('name', 'like', "%$keyword%")->latest('id')->paginate(5);
        } else {
            $data = Category::where('name', 'like', "%$keyword%")->latest('id')->paginate(5);
        }
        // dd($data);
        $count = [];
        $countAllCategory = Category::all()->count();
        $countActive = Category::where("is_active", 1)->count();
        $countPending = Category::where("is_active", 0)->count();
        $countTrashed = Category::onlyTrashed()->count();
        $count = [$countAllCategory, $countActive, $countPending, $countTrashed];
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'listAction'));
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
        $isActive = $request->isActive ? $request->isActive : 0;
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'is_active' => $isActive,
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
        $isActive = $request->isActive ? $request->isActive : 0;
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'is_active' => $isActive,
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
        $listCheck = $request->listCheck;
        if ($listCheck) {
            $act = $request->act;
            if ($act) {
                if ($act == "delete") {
                    Category::whereIn("id", $listCheck)->update(["is_active" => 0]);
                    Category::destroy($listCheck);
                    return redirect()->route("admin.categories.list")->with('success', 'Xoá thành công toàn bộ bản ghi đã chọn');
                }
                if ($act == "active") {
                    Category::whereIn("id", $listCheck)->update(["is_active" => 1]);
                    return redirect()->route("admin.categories.list")->with('success', 'Đăng toàn bộ những bản ghi đã chọn');
                }
                if ($act == "pending") {
                    Category::whereIn("id", $listCheck)->update(["is_active" => 0]);
                    return redirect()->route("admin.categories.list")->with('success', 'Chuyển đổi toàn bộ những bài viết về chờ xác nhận');
                }
                if ($act == "restore") {
                    Category::onlyTrashed()->whereIn("id", $listCheck)->restore();
                    return redirect()->route("admin.categories.list")->with('success', 'Khôi phục thành công toàn bộ bản ghi');
                }
                if ($act == "forceDelete") {
                    Category::onlyTrashed()->whereIn("id", $listCheck)->forceDelete();
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
