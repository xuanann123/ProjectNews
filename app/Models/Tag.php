<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name'];
    //Một tag thuộc về nhiều posts
    function posts() {
        return $this->belongsToMany(Post::class);
    }
    
}
