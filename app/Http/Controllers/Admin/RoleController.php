<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    const PATH_VIEW = "admin.roles.";

    function index()
    {
        $data = Role::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }
    function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view(self::PATH_VIEW . __FUNCTION__, compact('permissions'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => "required|max:255|unique:roles",
            'description' => "required",
        ], [
            "required" => ":attribute không được để trống",
            'unique'=> ":attribute không được trùng trên hệ thống"
        ], [
            'name' => "Tên vai trò",
            'description' => "Mô tả vai trò",
           
        ]);
        $data = $request->except('permission_id');
        $listPermissionID = $request->permission_id;
        //Thêm dữ liệu vào bảng role
        $role = Role::query()->create($data);
        $role->permissions()->sync($listPermissionID);
        return redirect()->route("admin.roles.index")->with('status', "Thêm vai trò thành công!");
    }
    function edit(Role $role) {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });

        $role_have_id_permission = $role->permissions()->pluck('permission_id')->toArray();
        return view(self::PATH_VIEW . __FUNCTION__, compact('role', 'permissions', 'role_have_id_permission'));
    }
    function update(Request $request, Role $role)
    {
        $request->validate([
            'name' =>'required|unique:users,name,'.$role->id,
            'description' => "required",
        ], [
            "required" => ":attribute không được để trống",
            'unique' => ":attribute không được trùng trên hệ thống"
        ], [
            'name' => "Tên vai trò",
            'description' => "Mô tả vai trò",
        ]);
        $data = $request->except('permission_id');
        $listPermissionID = $request->permission_id;
        DB::beginTransaction();
        try {
            $role->update($data);
            $role->permissions()->sync($listPermissionID);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return redirect()->route("admin.roles.index")->with('status', "Sửa vai trò thành công!");
    }

    function destroy(Role $role) {
        //Xoá ở bảng trung gian trước
        $role->permissions()->sync([]);
        $role->delete();
        return redirect()->route("admin.roles.index")->with('status', "Xoá vai trò thành công!");
    }
}
