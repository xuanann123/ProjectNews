<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    const TYPE_ADMIN = 'admin';
    const TYPE_MEMBER = 'member';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'image',
        'phone',
        'address',
        'description',
        'work',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //Thằng user này có quyền gì trên hệ thống
    function roles() {
        return $this->belongsToMany(Role::class, 'user_role');
    }
    //Một user có những bài viết nào
    function posts()
    {
        return $this->hasMany(Post::class);
    }
    //Có quyền này trên hệ thống hay không
    function hasPermission($permission) {
        //Cái này là kiểm tra user đó có những vai trò nào
        //Từ những vai trò thì kiểm tra tiếp xem nó có những quyền nào
        foreach ($this->roles as $role) {
            if($role->permissions->where('slug', $permission)->count() > 0) {
                return true;
            }
        }
        return false;
    }
}
