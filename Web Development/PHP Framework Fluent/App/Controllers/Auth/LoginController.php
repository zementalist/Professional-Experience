<?php

namespace App\Controllers\Auth;

use Core\Authentication\AuthenticatesUser;
use Core\Controller\Controller;

class LoginController extends Controller {
    use AuthenticatesUser;

    const REDIRECT_TO = "posts";
}

?>