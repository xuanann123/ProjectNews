<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CommentNotification;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    const PATH_VIEW = "admin.posts.";
    function index(Request $request)
    {
        $list_act = [
            'delete' => "Xoá (DELETE)",
            'active' => "Phê duyệt (ACTIVE)",
            'show_home' => "Hiển thị (SHOW)",
            'new' => "Bài viết mới (NEW)",
            'trend' => "Thịnh hành (TREND)",
            'pending' => "Không phê duyệt (NO ACTIVE)",
            'no_show_home' => "Không Hiển thị (NO SHOW)",
            'old' => "Bài viết cũ (OLD)",
            'no_trend' => "Không thịnh hành (NO TREND)",
        ];
        $status = $request->status;
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($status == "trash") {
            $list_act = [
                'restore' => "Khôi phục (RESTORE) ",
                'forceDelete' => "Xoá vĩnh viễn (FORCEDELETE)",
            ];

            $data = Post::onlyTrashed()->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "active") {
            //done
            $list_act = [
                'delete' => "Xoá (DELETE)",
                'show_home' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'no_show_home' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'no_trend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_active", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "trend") {
            //done
            $list_act = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'show_home' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'no_show_home' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'no_trend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_trending", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "new") {
            $list_act = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'show_home' => "Hiển thị (SHOW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'no_show_home' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'no_trend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_new", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "showHome") {
            $list_act = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'no_show_home' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'no_trend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_show_home", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "pending") {
            $list_act = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'show_home' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'no_show_home' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'no_trend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_active", 0)->where('title', 'like', "%$keyword%")->latest()->get();

        } else {
            $data = Post::query()->where('title', 'like', "%$keyword%")->latest()->get();
        }
        $count = [];
        $count_all = Post::all()->count();
        $count_active = Post::where("is_active", 1)->count();
        $count_show_home = Post::where("is_show_home", 1)->count();
        $count_is_new = Post::where("is_new", 1)->count();
        $count_is_trending = Post::where("is_trending", 1)->count();
        $count_pending = Post::where("is_active", 0)->count();
        $count_trash = Post::onlyTrashed()->count();
        $count = [$count_all, $count_active, $count_show_home, $count_is_new, $count_is_trending, $count_pending, $count_trash];
        // dd($countComment);

        return view(
            self::PATH_VIEW . __FUNCTION__,
            compact(
                'data',
                'list_act',
                'count',
            )
        );
    }
    function create()
    {
        $status_posts = [
            'is_active' => 'hoạt động',
            'is_new' => 'mới',
            'is_show_home' => 'ở trang chủ',
            'is_trending' => 'hot trend',
        ];

        $listCategory = Category::with('childrenRecursive')->where('parent_id', '0')->get();
        $tags = Tag::query()->latest()->get();

        return view(
            self::PATH_VIEW . __FUNCTION__,
            compact(
                'listCategory',
                'tags',
                'status_posts',
            )
        );
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required|exists:categories,id'
            ],
            [
                'required' => ":attribute không được để trống",
                'unique' => ":attribute đã tồn tại từ trước",
                'exists' => ":attribute phải tồn tại trong bảng categories",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'category_id' => 'Danh mục'
            ]
        );
        //NEW TAG sẽ lấy luôn giá trị của nó
        $list_tag_new = $request->input('new_tags')[0];
        if ($list_tag_new !== null) {
            $list_tag_new_array = explode(',', $list_tag_new);
        }
        $list_tag_new_array_id = [];
        //TAG POPULER
        $list_tag = $request->input("list_tag");
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->input('title'));
        $data['is_active'] = $request['is_active'] ??= 0;
        $data['is_new'] = $request['is_new'] ??= 0;
        $data['is_show_home'] = $request['is_show_home'] ??= 0;
        $data['is_trending'] = $request['is_trending'] ??= 0;
        $data['user_id'] = Auth::user()->id;
        //Đi upload ảnh như sau
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put("posts", $request->file('image'));
        }

        //Có thể đi dùng DB::commit
        DB::beginTransaction();
        try {
            //Thêm dữ liệu list_tag_new_array và tags
            if ($list_tag_new !== null) {
                foreach ($list_tag_new_array as $name_tag) {
                    $list_tag_new_array_id[] = Tag::create([
                        'name' => $name_tag
                    ])->id;
                }
                //Ok sau đó nó sẽ thêm toàn bộ value vào list_tag
                foreach ($list_tag_new_array_id as $key => $value) {
                    $list_tag[] = $value;
                }
            }
            //Thêm dữ liệu vào post
            $post = Post::create($data);
            $post->tags()->sync($list_tag);
            //Khi thêm xong thì DB::commit() đi
            DB::commit();
            return redirect()->route("admin.posts.index")->with('success', "Thêm bài bài viết thành công");
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->hasFile('image') && Storage::exists($data['image'])) {
                Storage::delete($data['image']);
            }
            throw new Exception($e->getMessage());
        }

    }
    function edit(Post $post)
    {
        $status_posts = [
            'is_active' => 'hoạt động',
            'is_new' => 'mới',
            'is_show_home' => 'ở trang chủ',
            'is_trending' => 'hot trend',
        ];
        $listCategory = Category::with('childrenRecursive')->where('parent_id', '0')->get();
        $tags = Tag::query()->latest()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('listCategory', 'tags', 'status_posts', 'post'));
    }

    function update(Post $post, Request $request)
    {
        //Đi validate trước nè
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required|exists:categories,id'
            ],
            [
                'required' => ":attribute không được để trống",
                'unique' => ":attribute đã tồn tại từ trước",
                'exists' => ":attribute phải tồn tại trong bảng categories",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'category_id' => 'Danh mục'
            ]
        );
        $list_tag = $request->input("list_tag");
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->input('title'));
        $data['is_active'] = $request['is_active'] ??= 0;
        $data['is_new'] = $request['is_new'] ??= 0;
        $data['is_show_home'] = $request['is_show_home'] ??= 0;
        $data['is_trending'] = $request['is_trending'] ??= 0;
        $data['user_id'] = Auth::user()->id;


        //Đi upload ảnh như sau
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put("posts", $request->file('image'));
        }
        //Có thể đi dùng DB::commit
        DB::beginTransaction();
        try {
            $current_image_post = $post->image;
            //Đi sửa dữ liệu bảng post nếu sửa xong
            $post->update($data);
            $post->tags()->sync($list_tag);
            if ($current_image_post) {
                if (Storage::exists($current_image_post) && $current_image_post && $request->hasFile('image')) {
                    Storage::delete($current_image_post);
                }
            }
            DB::commit();
            return redirect()->route("admin.posts.index")->with('success', "Sửa bài viết thành công");
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    function detail(Post $post)
    {

        return view(self::PATH_VIEW . __FUNCTION__, compact('post'));
    }
    function destroy(Post $post)
    {
        $post->update([
            "is_active" => 0,
            "is_show_home" => 0,
            "is_trending" => 0,
            "is_new" => 0,
        ]);
        $post->delete();
        return redirect()->route("admin.posts.index")->with('success', "Xoá bài bài viết thành công");
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act) {
                if ($act == "delete") {
                    Post::whereIn("id", $list_check)->update([
                        "is_active" => 0,
                        "is_show_home" => 0,
                        "is_trending" => 0,
                        "is_new" => 0,
                    ]);
                    Post::destroy($list_check);
                    return redirect()->route("admin.posts.index")->with('success', "Xoá (DELETE) thành công");
                }
                if ($act == "active") {
                    Post::query()->whereIn("id", $list_check)->update(["is_active" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái hoạt động của toàn bộ bản ghi");
                }
                if ($act == "show_home") {
                    Post::query()->whereIn("id", $list_check)->update(["is_show_home" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái hiển thị trên trang chủ của toàn bộ bản ghi");
                }
                if ($act == "new") {
                    Post::query()->whereIn("id", $list_check)->update(["is_new" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái mới của toàn bộ bản ghi");
                }
                if ($act == "trend") {
                    Post::query()->whereIn("id", $list_check)->update(["is_trending" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái xu hướng của toàn bộ bản ghi");
                }
                if ($act == "pending") {
                    Post::query()->whereIn("id", $list_check)->update(["is_active" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái hoạt động của toàn bộ bản ghi");
                }
                if ($act == "no_show_home") {
                    Post::query()->whereIn("id", $list_check)->update(["is_show_home" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái hiển thị của toàn bộ bản ghi");
                }
                if ($act == "old") {
                    Post::query()->whereIn("id", $list_check)->update(["is_new" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Chuỷen sang trạng thái cũ của toàn bộ bản ghi");
                }
                if ($act == "no_trend") {
                    Post::query()->whereIn("id", $list_check)->update(["is_trending" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái thịnh hành của toàn bộ bản ghi");
                }
                if ($act == "restore") {
                    Post::query()->whereIn("id", $list_check)->restore();
                    return redirect()->route("admin.posts.index")->with('success', "Khôi phục (RESTORE) bản ghi thành công");
                }
                if ($act == "forceDelete") {

                    DB::beginTransaction();
                    try {
                        foreach ($list_check as $id) {
                            $post = Post::withTrashed()->findOrFail($id);
                            //Xoá dữ liệu bảng trung
                            $post->tags()->detach();
                            //Xoá vĩnh viễn sản phẩm
                            $post->forceDelete();
                            $currentImage = $post->image;
                            //Xoá ảnh trong Storage
                            if ($currentImage && Storage::exists($currentImage)) {
                                Storage::delete($post->image);
                            }
                        }
                        DB::commit();
                        return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái hoạt động của toàn bộ bản ghi");
                    } catch (Exception $e) {
                        DB::rollBack();
                        //Đi khôi phục lại ảnh nếu làm sai
                        if ($post->image) {
                            Storage::put("posts", $post->image);
                        }
                        throw new Exception($e->getMessage());
                    }
                }
            } else {
                return redirect()->route("admin.posts.index")->with('error', "Vui lòng chọn thao tác để thực hiện");
            }

        } else {
            return redirect()->route("admin.posts.index")->with('error', "Vui lòng chọn bản ghi để thực hiện");

        }
    }
    function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route("admin.posts.index")->with('success', "Khôi phục bài viết thành công");

    }
    function forceDelete($id)
    {
        //Xoá vĩnh viễn 1 sản phẩm

        DB::beginTransaction();
        try {
            $post = Post::withTrashed()->findOrFail($id);
            //Xoá dữ liệu bảng trung
            $post->tags()->detach();
            //Xoá vĩnh viễn sản phẩm
            $post->forceDelete();
            $currentImage = $post->image;
            //Xoá ảnh trong Storage
            if ($currentImage && Storage::exists($currentImage)) {
                Storage::delete($post->image);
            }
            DB::commit();
            return redirect()->route("admin.posts.index")->with('success', "Xoá vĩnh viễn bài viết thành công");
        } catch (Exception $e) {
            DB::rollBack();
            //Đi khôi phục lại ảnh nếu làm sai
            if ($post->image) {
                Storage::put("posts", $post->image);
            }
            throw new Exception($e->getMessage());
        }
    }
}
