<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'image',
        'title',
        'description',
        'url',
        'is_active',
    ];
    protected $cats = [
        'is_active' => 'boolean'
    ];
    function user() {
        return $this->belongsTo(User::class);
    }
}
