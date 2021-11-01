<?php

namespace App\Middleware;

use App\Models\User;
use Core\Middleware\Middleware;

class AuthMiddleware extends Middleware {
    public $redirect_to = "login";
    public function allow() {
        return session()->key_exists(User::class);
    }
}

?>