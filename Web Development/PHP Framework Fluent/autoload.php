<?php
spl_autoload_register(function($className) {
    $filename = str_replace("\\", "/", $className) . ".php";
    
    if(file_exists($filename)){
        include_once $filename;
    }
    else {
        echo $filename;
    }
});

(new \Core\Foundation\DotEnv(__DIR__ . '/.env'))->load();

\Core\Session\Session::start();

function request() {
    return \Core\Request\Request::getRequest();
}
function view($path, array $context=[]) {
    return new \Core\View\View($path, $context);
}
function validator() {
    return \Core\Validation\Validator::class;
}
function temprequest() {
    return \Core\Request\Request::$tempRequest;
}

function session() {
    return new \Core\Session\Session;
}

function collect(array $data) {
    return new \Core\Structure\Stone($data);
}

function auth() {
    return new \Core\Authentication\Auth;
}
function response() {
    return new \Core\Response\Response;
}

function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] ;//. $_SERVER['REQUEST_URI'];
}

function current_path() {
    return $_GET["url"];
}

function report_error($message) {
    global $errors;
    if(is_array($message))
        array_push($errors, ...$message);
    else
        array_push($errors, $message);
    $_SESSION['errors'] = $errors;
}

function env($key, $default=null) {
    $value = getenv($key);
    return $value == false ? $default : $value;
}

function action($route, $controllerMethod, $requestMethod) {
    $requestMethod = strtolower($requestMethod);
    call_user_func("Core\Router::".$requestMethod, $route, $controllerMethod);
}

?>