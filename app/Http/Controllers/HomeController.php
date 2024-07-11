<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list_category_nav = $this->getMenu();
        // dd($list_category_nav);
        //Post New
        $post_new = $this->getNewPost();
        $date_new = $this->formattedDate($post_new->created_at);
        $post_new_content = $this->showText($post_new->excerpt);
        //Trending  Post
        $list_post_trend = $this->getListPostTrend()->random(3);
        //Popular Post
        $post_popular = $this->getPostPopular();
        $date_popular = $this->formattedDate($post_popular->created_at);
        $post_popular_content = $this->showText($post_popular->excerpt);
        //Banner
        $get_list_recent_post = $this->getListRecentPost();
        $get_list_recent_post_sidebar = $this->getListRecentPostSidebar()->random(3);

        //Slide
        $slides = Slide::query()->get();
        //Get list Tag
        $tags = Tag::query()->get()->random(9);
        //USER
        $list_user = $this->getListUser();
        //CATEGORY
        $list_category = $this->getListCategory()->random(6);
        return view(
            'client.home',
            compact(
                'list_category_nav',
                'post_new',
                'date_new',
                'post_new_content',
                'list_post_trend',
                'post_popular',
                'date_popular',
                'post_popular_content',
                'slides',
                'get_list_recent_post',
                'tags',
                'list_user',
                'list_category',
                'get_list_recent_post_sidebar'
            )
        );
    }

}
