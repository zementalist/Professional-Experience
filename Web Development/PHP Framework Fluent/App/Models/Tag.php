<?php

namespace App\Models;
use Core\Database\Model;


class Tag extends Model {
    protected $table = "tags";

    protected $fillable = ['name'];
    // protected $hidden = ["author", "content"];
    public function posts() {
        return $this->join(Post::class, 'category_id', 'id');
    }

}
?>