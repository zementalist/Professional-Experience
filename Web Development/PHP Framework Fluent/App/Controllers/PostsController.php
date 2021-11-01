<?php

namespace App\Controllers;

use Core\View\View;
use Core\Request\Request;
use Core\Validation\Validator;
use Core\Authentication\Auth;
use Core\Cryptography\Hash;
use Core\Controller\Controller;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PostTag;
use App\Models\User;
use App\Models\Color;
use App\Rules\MyRule;
use App\Rules\AnotherRule;



class PostsController extends Controller {

    public $model;

    public function __construct() {
        // $this->middleware('auth');
    }


    public function index() {
        $password = "zeyad";
        $user = session()->get(User::class);
        echo "LOGGED IN<br>";
        var_dump($user);
        return;
        return response()->redirect("/posts/edit/lol");
        return;
        $hashed = Hash::make($password);
        echo "<br>";
        // echo Hash::verify("zeyad", $hashed);
        echo Hash::verify("dayez", $hashed);
        return;

        // $post = Post::select(["posts.id", "posts.author", "tags.id", "tags.name"])->join(PostTag::class, "id", "post_id")->join(Tag::class, "tag_id", "id")->get();
        // $post = Post::select(["id","user_id"])->get()[0];
        // $color = Color::find(1);

        // $category = Category::find(1);
        // $user = User::find(1);
        echo "<br>";
        // $categories = $post->khambaloga;
        // $tags = $post->tags;
        // $posts = $user->posts;
        // $color = Color::create([
        //     'red' => 50,
        //     'green' => 60,
        //     'blue' => 70
        // ]);
        $color = Color::where("post_id", 32)->update(['blue' => 20]);
        // $color->update(['red' => 15]);
        var_dump($color);
        // foreach ($posts as $post) {
        //     var_dump($post);
        // }
        return;

        $category = new Category();
        $current = $category->find(1);
        var_dump($current[0]->except('id'));
        // echo $current["name"];
        return;
        var_dump($current);
        echo $current->name;
        echo property_exists($current, "test") ? "YES" : "NO";
    return ;
       $post = new Post();
       $post2 = new Post();
       $category = new Category();
       var_dump($category->getColumns());
        // var_dump($table_name);
        return;
        $p1 = new Post();
        $p2 = new Post();
        // return;
        Validator::make([
            'name' => "ahmed",
            "age" => 23,
            "nickname" => "ahmed",
            "test" => 200//new \Core\UploadedFile(['error' => 0, 'size' => 100, 'name' => 'xyz.jpg', 'tmp_name' => 'abc.png']),
        ], [
            "name" => ["required", new AnotherRule()],
            "age" => ["required", "between:10,20", "max:10"],
            "nickname" => "alphanumeric|in:mohamed,hamada,zeyad,ahmed",
            "empty" => "required",
            "test" => new MyRule(5,10)
        ]);
        return;
        $posts = $this->model->all();
        // $posts[1]->makeVisible(['author', 'content']);
        return json_encode($this->model->where([
            ['id', "!=", 3,'OR'],
            ['author', '=', "Zeyad"]
        ])->get());
    }

    public function lol() {
        echo "LOOOL";
        return "LOOL";
    }

    public function testa(Post $post, $request) {
        echo "Hi";
        return "Hi";
    }

    public function show($id) {
        $post = $this->model->find($id);
        $post->makeHidden(['image']);
        var_dump($post);
        $data = [
            'post' => $post,
            'categories' => $post->categories()[0]->all()
        ];
        // return json_encode($data);
        return new View('posts/show', $data);
    }

    public function edit() {
        // return new View("posts/edit");
    }

    public function showJson($id) {
        $post = $this->model->find($id);
        $data = [
            'post' => $post,
            'categories' => $post->categories()[0]->all()
        ];
        return json_encode($data);
    }

    public function update(Request $request) {
        
        // $var = $_SERVER;
        
        // var_dump($request->file('myfile')->store("/Storage/public/user/profiles"));
        // return new View("posts/edit");
        return;
        $var = $_REQUEST;
        // $var = $_REQUEST;
        $var = file_get_contents("php://input");
        // $var = $_FILES["myfile"];
        // print_r(json_decode($var, true));
    }
}

?>