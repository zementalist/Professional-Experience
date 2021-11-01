<?php

namespace App\Models;
use Core\Database\Model;


class Post extends Model {
    protected $table = "posts";


    protected $fillable = ['name'];
    // protected $hidden = ["author", "content"];
    // protected $with = ['tags'];

    public function category() {
        return $this->hasOne(Category::class, "category_id", "id");
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, PostTag::class, "post_id", "tag_id")->where("tags.name", "psychology");
    }

    public function color() {
        return $this->belongsTo(Color::class, "post_id", 'id');
    }

}
?>