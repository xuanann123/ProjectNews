<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'user_id', 'parent_id', 'is_active'];
    protected $cats = [
        'is_active' => 'boolean'
    ];
    function children()
    {
        return $this->hasMany(Category::class, "parent_id")->where('is_active', 1);
    }
    function parent()
    {
        return $this->belongsTo(Category::class, "parent_id");
    }
    function posts()
    {
        return $this->hasMany(Post::class);
    }
    //Đệ quy đến thằng con bé nhất
    function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

}
