<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function detail(Tag $tag) {
        $list_category_nav = $this->getMenu();
        $list_user = $this->getListUser();
        $list_category = $this->getListCategory()->random(5);
        $tags = Tag::query()->latest()->get()->random(9);
        $get_list_recent_post_sidebar = $this->getListRecentPostSidebar()->random(3);
        return view("client.tag.detail", compact('tag', 'list_category_nav', 'list_user', 'list_category', 'tags', 'get_list_recent_post_sidebar'));
    }
}
