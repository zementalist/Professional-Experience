<?php

namespace App\Controllers;

use Core\Controller\Controller;
use Core\View\View;

use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller {
    
    public function index() {
        $post = new Post();
        $posts = $post->all();
        $category = new Category();
        $categories = $category->all();

        $data = [
            'posts' => $posts,
            'categories' => $categories
        ];
        return new View("welcome", $data);
    }
    

}

?>