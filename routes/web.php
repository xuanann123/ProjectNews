<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\HomeController;
use App\Models\Comment; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get("/home", [HomeController::class, 'index'])->name('home');
Route::prefix("post")
    ->as("post.")
    ->group(function () {
        Route::get("/detail/{id}/{slug}",                           [App\Http\Controllers\Client\PostController::class, 'detail'])->name('detail');
        Route::get("/detail/cat/{category}/{slug}",                 [App\Http\Controllers\Client\PostController::class, 'detailCategory'])->name('detail.cat');
        Route::post('comments/store/{id}',                          [App\Http\Controllers\Client\PostController::class, 'storeComment'])->name('comments.store');
        Route::get('search',                                        [App\Http\Controllers\Client\PostController::class, 'search'])->name('search');
    });
Route::prefix("page")
    ->as("page.")
    ->group(function () {
        Route::get("/detail/{page}/{slug}",                         [App\Http\Controllers\Client\PageController::class, 'detail'])->name('detail');
        Route::get("/contact",                                      [App\Http\Controllers\Client\PageController::class, 'contact'])->name('contact');
    });
Route::prefix("profile")
    ->as("profile.")
    ->group(function () {
        Route::get("/index",                                        [ProfileController::class, 'index'])->name('index');
        Route::post("/update",                                      [ProfileController::class, 'update'])->name('update');

        // Route::get("/contact", [App\Http\Controllers\Client\PageController::class, 'contact'])->name('contact');
    });
Route::prefix("tag")
    ->as("tag.")
    ->group(function () {
        Route::get("/detail/{tag}",                                 [App\Http\Controllers\Client\TagController::class, 'detail'])->name('detail');
    });
//TRANG ADMIN
Route::middleware('checkAdmin')->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get("/",                                             [DashboardController::class, 'index'])->name('dashboard');
        Route::post("/readed/comment",                              [DashboardController::class, 'isRead'])->name('readed');
        Route::post("/watched/message",                             [DashboardController::class, 'isWatched'])->name('watched');
        //MODULE WITH SLIDE => DONE
        Route::prefix('comments')
            ->as('comments.')
            ->group(function () {
            Route::get("/",                                         [CommentController::class, 'index'])->name('index');
            Route::get("/destroy/{comment}",                        [CommentController::class, 'destroy'])->name('destroy');
        });
        //MODULE WITH CATEGORIES => DONE
        Route::prefix('categories')
            ->as('categories.')
            ->group(function () {
            Route::get("/",                                         [CategoryController::class, 'list'])->name('list')->can('category.show');
            Route::get("/create",                                   [CategoryController::class, 'create'])->name('create')->can('category.add');
            Route::post("/store",                                   [CategoryController::class, 'store'])->name('store')->can('category.add');
            Route::get("/edit/{category}",                          [CategoryController::class, 'edit'])->name('edit')->can('category.edit');
            Route::put("/update/{category}",                        [CategoryController::class, 'update'])->name('update')->can('category.edit');
            Route::get("/destroy/{category}",                       [CategoryController::class, 'destroy'])->name('destroy')->can('category.delete');
            Route::get("/action",                                   [CategoryController::class, 'action'])->name('action')->can('category.edit');
            Route::get("/restore/{id}",                             [CategoryController::class, 'restore'])->name('restore')->can('category.edit');
            Route::get("/forceDelete/{id}",                         [CategoryController::class, 'forceDelete'])->name('forceDelete')->can('category.edit');
        });

        //MODULE WITH POSTS => DONE
        Route::prefix('posts')
            ->as('posts.')
            ->group(function () {
            Route::get("/",                                         [PostController::class, 'index'])->name('index')->can('post.show');
            Route::get("/create",                                   [PostController::class, 'create'])->name('create')->can('post.add');
            Route::post("/store",                                   [PostController::class, 'store'])->name('store')->can('post.add');
            Route::get("/detail/{post}",                            [PostController::class, 'detail'])->name('detail')->can('post.show');
            Route::get("/edit/{post}",                              [PostController::class, 'edit'])->name('edit')->can('post.edit');
            Route::put("/update/{post}",                            [PostController::class, 'update'])->name('update')->can('post.edit');
            Route::get("/destroy/{post}",                           [PostController::class, 'destroy'])->name('destroy')->can('post.delete');
            Route::get("/restore/{id}",                             [PostController::class, 'restore'])->name('restore')->can('post.delete');
            Route::get("/forceDelete/{id}",                         [PostController::class, 'forceDelete'])->name('forceDelete')->can('post.delete');
            Route::get("/action",                                   [PostController::class, 'action'])->name('action')->can('post.edit');
        });
        //MODULE WITH TAGS => DONE
        Route::prefix('tags')
            ->as('tags.')
            ->group(function () {
            Route::get("/",                                         [TagController::class, 'index'])->name('index')->can('tag.show');
            Route::get("/create",                                   [TagController::class, 'create'])->name('create')->can('tag.add');
            Route::post("/store",                                   [TagController::class, 'store'])->name('store')->can('tag.add');
            Route::get("/edit/{tag}",                               [TagController::class, 'edit'])->name('edit')->can('tag.edit');
            Route::post("/update/{tag}",                            [TagController::class, 'update'])->name('update')->can('tag.edit');
            Route::get("/destroy/{tag}",                            [TagController::class, 'destroy'])->name('destroy')->can('tag.delete');
            Route::get("/restore/{id}",                             [TagController::class, 'restore'])->name('restore')->can('post.edit');
            Route::get("/forceDelete/{id}",                         [TagController::class, 'forceDelete'])->name('forceDelete')->can('post.delete');
            Route::get("/action",                                   [TagController::class, 'action'])->name('action')->can('post.edit');
        });
        //MODULE WITH USERS => DONE
        Route::prefix('users')
            ->as('users.')
            ->group(function () {
            Route::get("/",                                         [UserController::class, 'index'])->name('list')->can('user.show');
            Route::get("/create",                                   [UserController::class, 'create'])->name('create')->can('user.add');
            Route::post("/store",                                   [UserController::class, 'store'])->name('store')->can('user.add');
            Route::get("/destroy/{user}",                           [UserController::class, 'destroy'])->name('destroy')->can('user.delete');
            Route::get("/action",                                   [UserController::class, 'action'])->name('action')->can('user.edit');
            Route::get("/edit/{user}",                              [UserController::class, 'edit'])->name('edit')->can('user.edit');
            Route::put("/update/{user}",                            [UserController::class, 'update'])->name('update')->can('user.edit');
            Route::get("/detail/{user}",                            [UserController::class, 'detail'])->name('detail')->can('user.show');
            Route::get("/restore/{id}",                             [UserController::class, 'restore'])->name('restore')->can('user.edit');
            Route::get("/forceDelete/{id}",                         [UserController::class, 'forceDelete'])->name('forceDelete')->can('user.edit');
        });
        //MODULE WITH ROLE => DONE 
        Route::prefix('roles')
            ->as('roles.')
            ->group(function () {
            Route::get("/index",                                    [RoleController::class, 'index'])->name('index')->can('role.show');
            Route::get("/create",                                   [RoleController::class, 'create'])->name('create')->can('role.add');
            Route::post("/store",                                   [RoleController::class, 'store'])->name('store')->can('role.add');
            Route::get("/edit/{role}",                              [RoleController::class, 'edit'])->name('edit')->can('role.edit');
            Route::put("/update/{role}",                            [RoleController::class, 'update'])->name('update')->can('role.edit');
            Route::get("/destroy/{role}",                           [RoleController::class, 'destroy'])->name('destroy')->can('role.delete');
            //ACTION THAO TÁC NHIỀU BẢN GHI (hoàn thiện sau nhé)
        });
        //MODULE WITH PERMISSION
        Route::prefix('permissions')
            ->as('permissions.')
            ->group(function () {
            Route::get("/",                                         [PermissionController::class, 'create'])->name('create')->can('permission.show');
            Route::post("/store",                                   [PermissionController::class, 'store'])->name('store')->can('permission.add');
            Route::get("/edit/{permission}",                        [PermissionController::class, 'edit'])->name('edit')->can('permission.edit');
            Route::put("/update/{permission}",                      [PermissionController::class, 'update'])->name('update')->can('permission.edit');
            Route::get("/destroy/{permission}",                     [PermissionController::class, 'destroy'])->name('destroy')->can('permission.delete');
        });
        //MODULE WITH SLIDE => DONE
        Route::prefix('slides')
            ->as('slides.')
            ->group(function () {
            Route::get("/",                                         [SlideController::class, 'index'])->name('index')->can('slide.show');
            Route::get("/create",                                   [SlideController::class, 'create'])->name('create')->can('slide.add');
            Route::post("/store",                                   [SlideController::class, 'store'])->name('store')->can('slide.add');
            Route::get("/edit/{slide}",                             [SlideController::class, 'edit'])->name('edit')->can('slide.edit');
            Route::post("/update/{slide}",                          [SlideController::class, 'update'])->name('update')->can('slide.edit');
            Route::get("/destroy/{slide}",                          [SlideController::class, 'destroy'])->name('destroy')->can('slide.delete');
            Route::get("/restore/{id}",                             [SlideController::class, 'restore'])->name('restore')->can('slide.edit');
            Route::get("/forceDelete/{id}",                         [SlideController::class, 'forceDelete'])->name('forceDelete')->can('slide.delete');
            Route::get("/action",                                   [SlideController::class, 'action'])->name('action')->can('slide.edit');
        });
        //MODULE WITH Page
        Route::prefix('pages')
            ->as('pages.')
            ->group(function () {
            Route::get("/",                                         [PageController::class, 'index'])->name('index');
            Route::get("/create",                                   [PageController::class, 'create'])->name('create');
            Route::post("/store",                                   [PageController::class, 'store'])->name('store');
            Route::get("/edit/{page}",                              [PageController::class, 'edit'])->name('edit');
            Route::post("/update/{page}",                           [PageController::class, 'update'])->name('update');
            Route::get("/destroy/{page}",                           [PageController::class, 'destroy'])->name('destroy');
            Route::get("/restore/{id}",                             [PageController::class, 'restore'])->name('restore');
            Route::get("/forceDelete/{id}",                         [PageController::class, 'forceDelete'])->name('forceDelete');
            Route::get("/action",                                   [PageController::class, 'action'])->name('action');
        });
    });
Auth::routes();



