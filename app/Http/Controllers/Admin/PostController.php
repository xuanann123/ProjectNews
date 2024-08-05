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
        $listAction = [
            'delete' => "Xoá (DELETE)",
            'active' => "Phê duyệt (ACTIVE)",
            'showHome' => "Hiển thị (SHOW)",
            'new' => "Bài viết mới (NEW)",
            'trend' => "Thịnh hành (TREND)",
            'pending' => "Không phê duyệt (NO ACTIVE)",
            'noShowHome' => "Không Hiển thị (NO SHOW)",
            'old' => "Bài viết cũ (OLD)",
            'noTrend' => "Không thịnh hành (NO TREND)",
        ];
        $status = $request->status;
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($status == "trash") {
            $listAction = [
                'restore' => "Khôi phục (RESTORE) ",
                'forceDelete' => "Xoá vĩnh viễn (FORCEDELETE)",
            ];

            $data = Post::onlyTrashed()->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "active") {
            //done
            $listAction = [
                'delete' => "Xoá (DELETE)",
                'showHome' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'noShowHome' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'noTrend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_active", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "trend") {
            //done
            $listAction = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'showHome' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'noShowHome' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'noTrend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_trending", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "new") {
            $listAction = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'showHome' => "Hiển thị (SHOW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'noShowHome' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'noTrend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_new", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "showHome") {
            $listAction = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'pending' => "Không phê duyệt (NO ACTIVE)",
                'noShowHome' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'noTrend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_show_home", 1)->where('title', 'like', "%$keyword%")->latest()->get();
        } elseif ($status == "pending") {
            $listAction = [
                'delete' => "Xoá (DELETE)",
                'active' => "Phê duyệt (ACTIVE)",
                'showHome' => "Hiển thị (SHOW)",
                'new' => "Bài viết mới (NEW)",
                'trend' => "Thịnh hành (TREND)",
                'noShowHome' => "Không Hiển thị (NO SHOW)",
                'old' => "Bài viết cũ (OLD)",
                'noTrend' => "Không thịnh hành (NO TREND)",
            ];
            $data = Post::where("is_active", 0)->where('title', 'like', "%$keyword%")->latest()->get();

        } else {
            $data = Post::query()->where('title', 'like', "%$keyword%")->latest()->get();
        }
        $count = [];
        $countAll = Post::all()->count();
        $countActive = Post::where("is_active", 1)->count();
        $countShowHome = Post::where("is_show_home", 1)->count();
        $countIsNew = Post::where("is_new", 1)->count();
        $countIsTrending = Post::where("is_trending", 1)->count();
        $countPending = Post::where("is_active", 0)->count();
        $countTrash = Post::onlyTrashed()->count();
        $count = [$countAll, $countActive, $countShowHome, $countIsNew, $countIsTrending, $countPending, $countTrash];
        return view(
            self::PATH_VIEW . __FUNCTION__,
            compact(
                'data',
                'listAction',
                'count',
            )
        );
    }
    function create()
    {
        $statusPost = [
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
                'statusPost',
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
        $listTagNew = $request['newTags'][0];
        if ($listTagNew !== null) {
            $listTagNewArray = explode(',', $listTagNew);
        }
        $listTagNewArrayId = [];
        //TAG POPULER
        $listTag = $request->listTag;
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->input('title'));
        $data['is_active'] = 1;
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
            //Thêm dữ liệu listTagNewArray và tags
            if ($listTagNew !== null) {
                foreach ($listTagNewArray as $nameTag) {
                    $listTagNewArrayId[] = Tag::create([
                        'name' => $nameTag
                    ])->id;
                }
                //Ok sau đó nó sẽ thêm toàn bộ value vào listTag
                foreach ($listTagNewArrayId as $key => $value) {
                    $listTag[] = $value;
                }
            }
            //Thêm dữ liệu vào post
            $post = Post::create($data);
            $post->tags()->sync($listTag);
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
        $statusPosts = [
            'is_active' => 'hoạt động',
            'is_new' => 'mới',
            'is_show_home' => 'ở trang chủ',
            'is_trending' => 'hot trend',
        ];
        $listCategory = Category::with('childrenRecursive')->where('parent_id', '0')->get();
        $tags = Tag::query()->latest()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('listCategory', 'tags', 'statusPosts', 'post'));
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
        $listTag = $request->input("listTag");
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
            $CurrentImagePost = $post->image;
            //Đi sửa dữ liệu bảng post nếu sửa xong
            $post->update($data);
            $post->tags()->sync($listTag);
            if ($CurrentImagePost) {
                if (Storage::exists($CurrentImagePost) && $CurrentImagePost && $request->hasFile('image')) {
                    Storage::delete($CurrentImagePost);
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
        $listCheck = $request->listCheck;
        if ($listCheck) {
            $act = $request->input('act');
            if ($act) {
                if ($act == "delete") {
                    Post::whereIn("id", $listCheck)->update([
                        "is_active" => 0,
                        "is_show_home" => 0,
                        "is_trending" => 0,
                        "is_new" => 0,
                    ]);
                    Post::destroy($listCheck);
                    return redirect()->route("admin.posts.index")->with('success', "Xoá (DELETE) thành công");
                }
                if ($act == "active") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_active" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái hoạt động của toàn bộ bản ghi");
                }
                if ($act == "showHome") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_show_home" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái hiển thị trên trang chủ của toàn bộ bản ghi");
                }
                if ($act == "new") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_new" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái mới của toàn bộ bản ghi");
                }
                if ($act == "trend") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_trending" => 1]);
                    return redirect()->route("admin.posts.index")->with('success', "Kích hoạt trạng thái xu hướng của toàn bộ bản ghi");
                }
                if ($act == "pending") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_active" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái hoạt động của toàn bộ bản ghi");
                }
                if ($act == "noShowHome") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_show_home" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái hiển thị của toàn bộ bản ghi");
                }
                if ($act == "old") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_new" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Chuỷen sang trạng thái cũ của toàn bộ bản ghi");
                }
                if ($act == "noTrend") {
                    Post::query()->whereIn("id", $listCheck)->update(["is_trending" => 0]);
                    return redirect()->route("admin.posts.index")->with('success', "Tắt trạng thái thịnh hành của toàn bộ bản ghi");
                }
                if ($act == "restore") {
                    Post::query()->whereIn("id", $listCheck)->restore();
                    return redirect()->route("admin.posts.index")->with('success', "Khôi phục (RESTORE) bản ghi thành công");
                }
                if ($act == "forceDelete") {

                    DB::beginTransaction();
                    try {
                        foreach ($listCheck as $id) {
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
