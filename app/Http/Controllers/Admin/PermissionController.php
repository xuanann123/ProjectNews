<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    const PATH_VIEW = "admin.permissions.";
    function create()
    {
        //Lấy ra danh sách những quyền có thằng giống nay
        $list_permission = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view(self::PATH_VIEW . __FUNCTION__, compact('list_permission'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ":attribute không được quá 255 ký tự"
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Đường dẫn'
            ]
        );
        //Đi validate dữ liệu trước nè
        $data = $request->all();
        Permission::query()->create($data);
        return redirect()->route("admin.permissions.create")->with('status', "Thêm quyền thành công!");
    }
    function edit(Permission $permission) {
        //Lấy ra danh sách những quyền có thằng giống nay
        $list_permission = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view(self::PATH_VIEW . __FUNCTION__, compact('permission', 'list_permission'));
    }
    function update(Permission $permission, Request $request) {
        $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ":attribute không được quá 255 ký tự"
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Đường dẫn'
            ]
        );
        $data = $request->all();
        $permission->update($data);
        return redirect()->route("admin.permissions.create")->with('status', "Sửa quyền thành công!");
    }
    function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route("admin.permissions.create")->with('status', "Xoá quyền thành công!");
    }
}
