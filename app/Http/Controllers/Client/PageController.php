<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    function detail(Page $page)
    {
        //Get list Tag
        $tags = Tag::query()->get();
        $list_category_nav = getMenu();
        return view('client.page.detail', compact('page', 'list_category_nav', 'tags'));
    }
    function contact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'reason' => $request->reason,
            'message' => $request->message,
        ];
        ContactMessage::create($details);
        Mail::to("annxph37114@fpt.edu.vn")->send(new ContactMail($details));
        return redirect()->route('home')->with('success', 'Gửi email thành công đến quản trị');
    }
}
function getMenu()
{
    $list_category_nav = [];

    $list_category_nav[] = Page::where("is_active", 1)->get();

    //NAV category
    $list_category_nav[] = $listCategory = Category::with('children')->where('parent_id', '0')->get();
    return $list_category_nav;
}
