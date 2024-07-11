<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    function getMenu()
    {
        $list_category_nav = [];

        $list_category_nav[] = Page::where("is_active", 1)->get();

        //NAV category
        $list_category_nav[] = $listCategory = Category::with('children')->where(['parent_id'=> '0', 'is_active'=> 1])->get();
        return $list_category_nav;
    }
    function getNewPost()
    {
        $post = Post::query()->where("is_active", "1")->latest()->first();
        return $post;
    }
    function formattedDate($d)
    {
        $date = Carbon::parse($d);
        $formattedDate = $date->format('d M, Y');
        return $formattedDate;
    }
    function showText($text)
    {
        $limitedText = Str::limit($text, 100); // Giới hạn văn bản đến 25 ký tự
        return $limitedText;
    }
    function getListPostTrend()
    {
        $posts = Post::query()->where('is_trending', "1")->where("is_active", "1")->get();
        return $posts;
    }
    function getListUser()
    {
        $list_user = User::query()->get();
        return $list_user;
    }
    function getListCategory()
    {
        $category = Category::query()->where("is_active", "1")->get();
        return $category;
    }
    function getPostPopular()
    {
        $post = Post::query()->where([
            'is_trending' => "1",
            'is_new' => "1",
            "is_show_home" => "1",
            "is_active" => "1"
        ])->orderBy('view', "desc")->first();
        return $post;
    }
    function getListRecentPost()
    {
        $posts = Post::query()->where([
            'is_new' => "1",
            "is_show_home" => "1",
            "is_active" => "1"
        ])->latest()->paginate(4);
        return $posts;
    }
    function getListRecentPostSidebar()
    {
        $posts = Post::query()->where([
            'is_new' => "1",
            "is_show_home" => "1",
            "is_active" => "1"
        ])->latest()->get();
        return $posts;
    }
}
