<?php

namespace App\Models;
use Core\Database\Model;


class PostTag extends Model {
    protected $table = "posts_tags";

    // protected $fillable = ['name'];
    // protected $hidden = ["author", "content"];
    public function categories() {
        return $this->join(Category::class, 'category_id', 'id');
    }

}
?>