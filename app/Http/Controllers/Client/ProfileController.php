<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    function index() {
        $list_category_nav = $this->getMenu();
        return view('client.profile.index', compact('list_category_nav'));
    }
    function update(Request $request) {
        $user = Auth::user();
        //Kiểm tra xem nó có đi upload ảnh không
        if($request->hasFile('image')) {
          $image_new =  Storage::put('profile', $request->file('image'));
        } else {
            $image_new = Auth::user()->image;
        }
        $current_image_user = $user->image;

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'age' => $request->age,
            'phone' => $request->phone,
            'work' => $request->work,
            'image' => $image_new
        ]);
        if($request->hasFile('image') && $current_image_user && Storage::exists($current_image_user)) {
            Storage::delete($current_image_user);
        }
        return back()->with('success', "Cập nhật profile thành công!");
    }
}
