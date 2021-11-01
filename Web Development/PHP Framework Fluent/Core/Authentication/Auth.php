<?php

namespace Core\Authentication;

use Core\Router\Router;
use Core\Cryptography\Hash;
use App\Models\User;
use App\Middleware\AuthMiddleware;

class Auth {

    /**
     * Object of the logged user
     *
     * @var App\Models\User
     */
    private static ?User $user = null;
    
    /**
     * Return the logged user
     *
     * @return App\Models\User
     */
    public static function user() {
        return self::$user;
    }

    /**
     * Return the column that represents username in 'users' table
     *
     * @return string
     */
    public static function usernameKey() {
        return "email";
    }

    /**
     * Return the ID of the logged user
     *
     * @return string
     */
    public static function id() {
        $identifierKey = $this->user->getPrimaryKey();
        return self::$user["$identifierKey"];
    }

    /**
     * Check if the user is logged in
     *
     * @return bool
     */
    public static function check() {
        return isset(self::$user);
    }

    /**
     * Report error to $errors global variable
     *
     * @return void
     */
    public static function error() {
        report_error("These credentials do not match our records.");
    }

    /**
     * Run the login process
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @return bool
     */
    public static function attempt(array $credentials, $remember=false) {
        $usernameKey = Auth::usernameKey();
        $usernameValue = $credentials["$usernameKey"];
        $user = User::where($usernameKey, '=', $usernameValue)->get();
        if($user) {
            $user = $user[0];
            $input_password = $credentials["password"];
            $password_verified = \Core\Hash::verify($input_password, $user->password);
            if($password_verified) {
                self::$user = $user;
                return true;
            }        
        }
        self::error();
        return false;
    }

    /**
     * Log out the logged user
     *
     * @return void
     */
    public static function logout() {

    }


    /**
     * Log a specific user in
     *
     * @param  App\Models\User  $user
     * @return void
     */
    public static function login(User $user) {
        self::$user = $user;
    }


    /**
     * Provide authentication routes
     *
     * @return array
     */
    public function routes() {
        $routes = [
            \Core\Router::get("login", "Auth\LoginController@showLoginForm"),
            \Core\Router::post("login", "Auth\LoginController@login"),
            \Core\Router::get("register", "Auth\RegisterController@showRegistrationForm"),
            \Core\Router::post("register", "Auth\RegisterController@register")
        ];
        return $routes;
    }

    /**
     * Return Auth Middleware class
     *
     * @return App\Middleware\AuthMiddleware
     */
    public static function middleware() {
        return AuthMiddleware::class;
    }

}
?>