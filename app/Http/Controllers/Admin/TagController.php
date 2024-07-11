<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    const PATH_VIEW = "admin.tags.";
    function index(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            "delete" => "Xoá toàn bộ",
        ];
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($status == "trash") {
            $list_act = [
                "restore" => "Khôi phục toàn bộ",
                "forceDelete" => "Xoá vĩnh viễn toàn bộ",
            ];
            $data = Tag::onlyTrashed()->where("name", "like", "%$keyword%")->latest()->get();
        } else {
            $data = Tag::query()->where("name", "like", "%$keyword%")->latest()->get();
        }
        $count_all = Tag::all()->count();
        $count_trash = Tag::onlyTrashed()->count();
        $count = [$count_all, $count_trash];
        #NOTIFICATION COMMENT
        $commentNotifications = CommentNotification::where('is_read', false)->orderBy('created_at', 'desc')->get();
        #NOTIFICATION COMMENT
        $messageNotifications = ContactMessage::where('is_read', false)->orderBy('created_at', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'count', 'list_act', 'commentNotifications', 'messageNotifications'));
    }
    function create()
    {
        $tags = Tag::query()->latest()->get();
        #NOTIFICATION COMMENT
        $commentNotifications = CommentNotification::where('is_read', false)->orderBy('created_at', 'desc')->get();
        #NOTIFICATION COMMENT
        $messageNotifications = ContactMessage::where('is_read', false)->orderBy('created_at', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('tags', 'commentNotifications', 'messageNotifications'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => "required",
            ],
            [
                'required' => 'Vui lòng điền vào :attribute',
            ],
            [
                'name' => "tên thẻ"
            ]
        );
        Tag::create([
            "name" => $request->name,
        ]);
        return redirect()->route("admin.tags.index")->with('success', "Thêm thẻ thành công");
    }
    function edit(Tag $tag)
    {
        $tags = Tag::query()->latest()->get();
        #NOTIFICATION COMMENT
        $commentNotifications = CommentNotification::where('is_read', false)->orderBy('created_at', 'desc')->get();
        #NOTIFICATION COMMENT
        $messageNotifications = ContactMessage::where('is_read', false)->orderBy('created_at', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('tags', 'tag', 'commentNotifications', 'messageNotifications'));
    }
    function update(Tag $tag, Request $request)
    {
        $request->validate(
            [
                'name' => "required",
            ],
            [
                'required' => 'Vui lòng điền vào :attribute',
            ],
            [
                'name' => "tên thẻ"
            ]
        );
        $tag->update([
            "name" => $request->name
        ]);
        return redirect()->route("admin.tags.index")->with('success', "Sửa thẻ thành công");
    }
    function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route("admin.tags.index")->with('success', "Xoá thẻ thành công");

    }
    function action(Request $request) {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act) {
                if ($act == "delete") {
                    Tag::destroy($list_check);
                    return redirect()->route("admin.tags.index")->with('success', "Xoá toàn bộ thành công");
                }
                if ($act == "restore") {
                    Tag::withTrashed()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.tags.index")->with('success', "Khôi phục toàn bộ bản ghi thành công");
                }
                if ($act == "forceDelete") {
                    Tag::withTrashed()->whereIn("id", $list_check)->forceDelete();
                    return redirect()->route("admin.tags.index")->with('success', "Xoá vĩnh viễn thẻ khỏi hệ thống");
                }
            } else {
                return redirect()->route("admin.tags.index")->with('error', "Vui lòng chọn thao tác để thực hiện");
            }

        } else {
            return redirect()->route("admin.tags.index")->with('error', "Vui lòng chọn bản ghi để thực hiện");

        }
    }

    function forceDelete($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route("admin.tags.index")->with('success', 'Xoá vĩnh viễn bản ghi ra khỏi hệ thống');
    }
    function restore($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->restore();
        return redirect()->route("admin.tags.index")->with('success', 'Bạn đã khôi phục thành công');
    }
}
