<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_VIEW = "admin.users.";

    function index(Request $request)
    {
        $status = $request->input("status") ? $request->input("status") : 'active';
        $keyword = "";
        $list_act = [
            'delete' => "Xoá toàn bộ"
        ];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($status == "trash") {

            $list_act = [
                'restore' => "Khôi phục toàn bộ",
                'forceDelete' => "Xoá vĩnh viễn toàn bộ"
            ];
            $data = User::onlyTrashed()->where("name", "like", "%$keyword%")->latest()->get();
        } else {
            $data = User::query()->where("name", "like", "%$keyword%")->latest()->paginate();
        }
        $count = [];
        $count_ative = User::all()->count();
        $count_trash = User::onlyTrashed()->count();
        $count = [$count_ative, $count_trash];

        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'list_act'));
    }
    function create()
    {
        $roles = Role::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('roles'));
    }
    function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => "Không được để trống :attribute",
                'unique' => "Đã tồn tại bản ghi :attribute từ trước",
                'confirmed' => "Mật khẩu bắt buộc phải trùng",
                'min' => ":attribute phải lớn hơn 8 kí tự",
            ],
            [
                'name' => "họ và tên",
                'email' => "địa chỉ email",
                'password' => "Mật khẩu",
            ]
        );
        $list_role = $request->list_role;
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put("users", $request->file('image'));
        }
        $data['type'] = $request->input('type') ? User::TYPE_ADMIN : User::TYPE_MEMBER;
        DB::beginTransaction();
        try {
            $user_create = User::create($data);
            $user_create->roles()->sync($list_role);
            DB::commit();
        } catch (Exception $th) {
            if(Storage::exists($data['image']) && $request->hasFile('image')) {
                Storage::delete($data['image']);
            }
            DB::rollBack();
        }

        return redirect()->route("admin.users.list")->with('status', "Thêm người dùng thành công");
    }
    function edit(User $user)
    {
        //Lấy danh sách id_role của user đó ra
        $list_role_user = $user->roles()->pluck('role_id')->toArray();
        $roles = Role::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('user', 'roles', 'list_role_user'));
    }
    function update(Request $request, User $user)
    {
        $data = [
            "name" => $request->input("name"),
            "phone" => $request->input("phone"),
            "address" => $request->input("address"),
            "description" => $request->input("description"),
            "work" => $request->input("work"),
        ];
        $list_role = $request->list_role;

        //Kiểm tra xem có update ảnh không
        if ($request->hasFile('image')) {
            //Lưu trữ ảnh này vào storage
            $data['image'] = Storage::put("profile", $request->file('image'));
        }
        $currentImage = $user->image;
        $user->update($data);
        $user->roles()->sync($list_role);
        //xoá ảnh trong storage
        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }
        return redirect()->route("admin.users.list")->with('status', "Cập nhật người dùng thành công");

    }
    function destroy(User $user)
    {
        $user->update([
            'type' => User::TYPE_MEMBER
        ]);
        $user->deleteOrFail();
        return redirect()->route("admin.users.list")->with('status', "Xoá người dùng thành công");
    }
    function detail(User $user)
    {
        return view("admin.users.detail", compact('user'));
    }
    //MY PROFILE

    // function updateProfile(Request $request)
    // {
    //     $user = Auth::user();

    //     $data = [
    //         "name" => $request->input("name"),
    //         "phone" => $request->input("phone"),
    //         "address" => $request->input("address"),
    //         "description" => $request->input("description"),
    //         "work" => $request->input("work"),
    //     ];
    //     // dd($data);
    //     //Kiểm tra xem có update ảnh không
    //     if ($request->hasFile('image')) {
    //         //Lưu trữ ảnh này vào storage
    //         $data['image'] = Storage::put("profile", $request->file('image'));
    //     }
    //     $currentImage = $user->image;

    //     $user->update($data);
    //     //xoá ảnh trong storage
    //     if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
    //         Storage::delete($currentImage);
    //     }
    //     return back();
    // }
    function action(Request $request)
    {
        //Oki bắt đầu thực hiện
        //Nếu như k có hành động thì thông báo
        //NẾu không có không có list_check thì thông báo 
        //Và hơn nữa thì loại bỏ thằng user cha
        //Oki bắt đầu thực hiện 

        $list_check = $request->input('list_check');

        if ($list_check) {
            //Xoá thằng người dùng ra khỏi listcheck => không cho phép chính mình xoá mình
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    //Xoá đi chính thằng có $k có giá trị id = id của bản thân mình
                    unset($list_check[$k]);
                }
            }
            //Tiếp đo đi keierm tra tiếp hành động là gì
            $act = $request->input('act');
            if ($act) {
                //Xoá
                if ($act == "delete") {
                    User::destroy($list_check);
                    return redirect()->route("admin.users.list")->with('status', "Xoá toàn bộ bản ghi đã chọn");
                }
                //restore
                if ($act == "restore") {
                    User::withTrashed()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.users.list")->with('status', "Bạn đã khôi phục toàn bộ bản ghi");
                }
                //forceDelete
                if ($act == "forceDelete") {
                    User::withTrashed()->whereIn("id", $list_check)->forceDelete();
                    return redirect()->route("admin.users.list")->with('status', "Bạn đã xoá toàn bộ bản ghi đã chọn");
                }
            } else {
                return redirect()->route("admin.users.list")->with('status', "Vui lòng mời bạn chọn thao tác thực hiện");
            }
        } else {
            return redirect()->route("admin.users.list")->with('status', "Vui lòng mời bạn chọn bản ghi để thực hiện");
        }

    }
    function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id)->restore();
        return redirect()->route("admin.users.list")->with('status', "Khôi phục thành công thành viên");
    }
    function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route("admin.users.list")->with('status', 'Xoá vĩnh viễn bản ghi ra khỏi hệ thống');
    }


}
