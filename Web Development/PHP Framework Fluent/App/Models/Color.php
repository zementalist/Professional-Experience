<?php

namespace App\Models;
use Core\Database\Model;


class Color extends Model {
    protected $table = "colors";
    protected $primaryKey = "post_id";
    // protected $fillable = ['name'];
    // protected $hidden = ["author", "content"];
    // protected $with = ['tags'];

    public function post() {
        return $this->hasOne(Post::class, "id", "post_id");
    }


}
?>