<?php

namespace App\Models;
use Core\Database\Model;


class User extends Model {
    protected $table = "users";

    // protected $fillable = ['name'];
    protected $hidden = ['password'];
    // protected $with = ['tags'];
    const CREATED_AT = 'created_at';

    public function posts() {
        return $this->hasMany(Post::class, "user_id", "id");
    }


}
?>