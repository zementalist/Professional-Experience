<?php
use Core\Router\Router;


// Router::get("someone/lol", "PostsController@test");
Router::get("/", "HomeController@index");
Router::get("posts/{id}", "PostsController@show");
Router::get("posts/all/{test}", "PostsController@index")->middleware('auth');

// Router::get("posts/edit", "PostsController@edit");
Router::post("posts/edit/{id}/{name}/fix", "PostsController@update");

Router::get("posts/edit/lol", "PostsController@lol");

Router::group(["one", "two", "three"], function() {
    Router::get("/test/again", "SomeController@gmail");

    Router::post("/test/BAD", "JUSTCONTROLLER@gmail")->withoutMiddleware("one");
});

auth()->routes();

Router::register();
?>