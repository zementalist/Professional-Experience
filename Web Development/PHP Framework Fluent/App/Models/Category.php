<?php

namespace App\Models;
use Core\Database\Model;

class Category extends Model {
    protected $table = "categories";
    protected $primaryKey = "id";

    protected $fillable = ['name'];
    // protected $hidden = ['name'];
    public function posts() {
        return $this->hasMany(Post::class, "category_id", "id");
    }
}

?>