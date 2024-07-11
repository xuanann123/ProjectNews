<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment_id',
        'is_read',
    ];
    function comment() {
        return $this->belongsTo(Comment::class);
    }
}
