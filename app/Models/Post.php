<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'image',
        'slug',
        'excerpt',
        'content',
        'is_active',
        'user_id',
        'category_id',
        'view',
        'is_new',
        'is_show_home',
        'is_trending',
    ];
    protected $cats = [
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'is_show_home' => 'boolean',
        'is_trending' => 'boolean',
    ];
    public function category() {
        return $this->belongsTo(Category::class)->where('is_active', 1);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    //Một bài viết có nhiều comment -> lấy những phần bài viết có parent_id là rỗng
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
    public function commentsTotal()
    {
        return $this->hasMany(Comment::class);
    }
    public function views()
    {
        return $this->hasMany(PostView::class);
    }
}
