<?php

namespace Core\Router;

class Router {

    /**
     * All routes of the application
     *
     * @var string
     */
    private static $routes = [];

    /**
     * List of callbacks which should edit meta data about route(s)
     *
     * @var string
     */
    private static $tasks_to_run = [];

    /**
     * Match current route with one route of $routes
     *
     * @param  string $path
     * @param string $url_data
     * @param bool $unparametric
     * @return array
     */
    private static function match($path, $current_url, $unparametric=true) {
        // Un-parametric matches are the routes which doesn't contain
        // parameters in URL, this type of routes are higher in priorty
        // if two routes matched the current route, the unparametric one
        // will be returned
        $unparametric_matches = [];
        $parametric_matches = [];

        $path = rtrim(ltrim($path, '/'), '/');
        $current_url = rtrim(ltrim($current_url, '/'), '/');
        $url_to_compare = str_replace("/", "\/", $path);
        $pattern = "/^$url_to_compare$/";

        // If search is directed onto the un-parametric routes
        if($unparametric) {
            //  Find UN-parametric matches
            preg_match($pattern, $current_url, $unparametric_matches);
            return $unparametric_matches;
        }

        // else, search is directed onto the parametric routes
        else {
            $url_to_compare = "^" . preg_replace("/\{\w+\}/", "([a-zA-z0-9]+)", $url_to_compare) . "$";
            $pattern = "/$url_to_compare/";

            // Prevent comparison between empty pattern any non-empty current url (because they always match)
            if($url_to_compare == "$" && $current_url != '') {
                return $parametric_matches;
            }

            // Find parametric matches matches
            preg_match($pattern, $current_url, $parametric_matches);
            return $parametric_matches;
        }
    }

    /**
     * Split 'ControllerName@Method' into [ControllerName, Method]
     *
     * @param  string $task
     * @return array
     */
    public static function splitControllerMethodNames($task) {
        // function to  "ControllerName@Method" => ["ControllerName", "Method"];
        $chunks = explode("@", $task);
        [$controllerName, $methodName] = $chunks;
        $controllerName = "\App\Controllers\\$controllerName";
        return [$controllerName, $methodName];
    }

    /**
     * Extract parameters name from parametric route
     *
     * @param  string $path
     * @return array
     */
    private static function extract_parameter_names($path) {
        $parameters_names_array = null;
        $parameters = [];
        preg_match_all("/\{\w+\}/", $path, $parameters_names_array);
        foreach ($parameters_names_array[0] as $parameter) {
            $parameter = substr($parameter, 1, strlen($parameter)-2);
            array_push($parameters, $parameter);
        }
        return $parameters;
    }

    /**
     * Build a key:value pairs of route parameters & current url arguments
     *
     * @param  array $parameters
     * @param array $arguments
     * @return array
     * 
     * @throws \Exception
     */
    private static function assign_parameters_to_arguments($parameters, $arguments) {
        if(count($parameters) == count($arguments)) {
            return array_combine($parameters, $arguments);
        }
        else {
            throw new \Exception("Wrong number of parameters", 1);
        }
    }

    /**
     * Arrange arguments of the controller's method
     *
     * @param  string $controllerName
     * @param string $methodName
     * @param array $data
     * @param Core\Request $request
     * @return array
     */
    private static function arrange_args_for_controller($controllerName, $methodName, $data=[], Request $request) {
        // Arrange controller's method parameters appropriately
        // controller's method parameters are arranged as the URL params
        // if controller's method have Request parameter, it's appended in the correct position in args

        $args = [];

        // Get info about controller's method
        $reflection = new \ReflectionMethod($controllerName, $methodName);

        // Get parameters of controller's method
        $parameters = $reflection->getParameters();

        // Keep track of URL arguments
        $data_counter = 0;

        // The number of controller's method parameters
        $method_arguments_count = count($parameters);

        // Loop over controller's method parameters
        for($i = 0; $i < $method_arguments_count; $i++)
        {
            $parameter = $parameters[$i];
            $parameterType = $parameter->getType();

            // Check if parameter type is available     && if it's a request
            if($parameterType instanceof \ReflectionType && $parameterType->getName() == "Core\Request"){
                // Append $request as the first argument
                array_push($args, $request);
            }

            // No type for the parameter, append URL data if exists
            else{
                if($data_counter < count($data))
                    array_push($args, $data[$data_counter++]);
                else
                    throw new \Exception("Too few arguments passed to '$controllerName@$methodName'", 1);
            }
        }
        return $args;

    }

    /**
     * Apply middleware associated with a route
     *
     * @param  array $route
     * @return void|false
     * 
     * @throws \Exception
     */
    private static function applyMiddleware($route) {
        $middleware_type = $route['middleware'];
        if(isset($middleware_type)) {
            return \App\Providers\MiddlewareProvider::apply($middleware_type);
        }
    }

    /**
     * Set a session variable which holds the previous URL
     *
     * @param  string $new_url
     * @return void
     */
    private static function setPreviousUrl($new_url) {
        $current_url = session()->get("current_url", $new_url);
        if($current_url != $new_url);
            session()->set("previous_url", $current_url);
    }

    /**
     * Set a session variable which holds the current URL
     *
     * @param  string $url
     * @return void
     */
    private static function setCurrentUrl($url) {
        session()->set("current_url", $url);
    }

    /**
     * Handle a request (matched route)
     *
     * @param  array $route
     * @param array $args
     * @return void
     */
    private static function handle($route, $args=[]) {

        // Apply middleware if exists & stop routing if middleware failed
        if($middleware_failed = self::applyMiddleware($route))
            return $middleware_failed;

        // if task is a string, a pattern is expected: "ControllerName@MethodName
        if(gettype($route['callback']) == "string") {
            $parameters = self::extract_parameter_names($route['url']);
            $url_data = self::assign_parameters_to_arguments($parameters, $args);

            // Get controller & call its function
            try {
                [$controllerName, $methodName] = self::splitControllerMethodNames($route['callback']);
                $controller = new $controllerName();
                $request = new Request($route, $url_data);
                $arguments_arranged = self::arrange_args_for_controller($controllerName, $methodName, $args, $request);
                $result = $controller->$methodName(...$arguments_arranged);
            }
            catch(\Exception $e) {
                throw new \Exception($e->getMessage(), 1);
            }

            // Set previous & current URL
            self::setPreviousUrl($route['url']);
            self::setCurrentUrl($route['url']);

            echo $result; // important, this line shows HTML content
            return $result; // of calling controller->method()
        }

        // else if task is a callback 
        else if(is_callable($task)) {
            call_user_func($task, ...$args);
        }

        // else, unknown task
        else {
            throw new \Exception("Unexecutable task at route: " . $route['url'], 1);
        }
    }

    /**
     * Create a GET route
     *
     * @param  string $path
     * @param string|callback $task
     * @return Router
     */
    public static function get($path, $task) {
        array_push(self::$routes, [
            'url' => $path,
            'method' => "GET",
            'callback' => $task,
            'middleware' => null
        ]);
        return new self;
    }

    /**
     * Run the router
     *
     * @return void
     * 
     * @throws \Exception
     */
    public static function register() {
        // Search & match URLs
        $unparametric_matches_all = [];
        $parametric_matches_all = [];
        $matched_unparametric_routes = [];
        $matched_parametric_routes = [];

        // Loop through URLs, find matches, prioritize un-parametric routes, handle first match
        foreach(self::$routes as $route) {
            // Find matches
            $unparametric_matches = self::match($route['url'], $_REQUEST['url'], true);
            $parametric_matches = self::match($route['url'], $_REQUEST['url'], false);
            if(count($unparametric_matches) > 0) {
                array_push($unparametric_matches_all, $unparametric_matches);
                array_push($matched_unparametric_routes,$route);
            }
            if(count($parametric_matches) > 0) {
                array_push($parametric_matches_all, $parametric_matches);
                array_push($matched_parametric_routes,$route);
            }
        }

        // Prioritize unparametric routes
        if(count($unparametric_matches_all) > 0) {
            // Find first route that match REQUEST_METHOD & handle it
            $route_index = array_search($_SERVER['REQUEST_METHOD'], array_column($matched_unparametric_routes, 'method'));
            self::handle($matched_unparametric_routes[$route_index]);
        }
        else if(count($parametric_matches_all) > 0) {
            // Find first route that match REQUEST_METHOD & handle it
            $route_index = array_search($_SERVER['REQUEST_METHOD'], array_column($matched_parametric_routes, 'method'));
            
            // Add parameters
            $params = array_slice($parametric_matches_all[$route_index], 1);
            $route_index = array_search($_SERVER['REQUEST_METHOD'], array_column($matched_parametric_routes, 'method'));
            
            // Handle matched route
            self::handle($matched_parametric_routes[$route_index], $params);
        }
        else {
            // No matching route, maybe show 404 page
            throw new \Exception("No matching route", 1);
        }
    }

    /**
     * Create a POST route
     *
     * @param  string $path
     * @param string|callback $task
     * @return Request
     */
    public static function post($path, $task) {
        array_push(self::$routes, [
            'url' => $path,
            'method' => "POST",
            'callback' => $task,
            'middleware' => null
        ]);
        return new self;
    }

    /**
     * Create a PUT route
     *
     * @param  string $path
     * @param string|callback $task
     * @return Request
     */
    public static function put($path, $task) {
        array_push(self::$routes, [
            'url' => $path,
            'method' => "PUT",
            'callback' => $task,
            'middleware' => null
        ]);
        return new self;
    }

    /**
     * Create a PATCH route
     *
     * @param  string $path
     * @param string|callback $task
     * @return Request
     */
    public static function patch($path, $task) {
        array_push(self::$routes, [
            'url' => $path,
            'method' => "PATCH",
            'callback' => $task,
            'middleware' => null
        ]);
        return new self;
    }

    /**
     * Create a DELETE route
     *
     * @param  string $path
     * @param string|callback $task
     * @return Request
     */
    public static function delete($path, $task) {
        array_push(self::$routes, [
            'url' => $path,
            'method' => "DELETE",
            'callback' => $task,
            'middleware' => null
        ]);
        return new self;
    }

    /**
     * Set a middleware for the last created route
     *
     * @param  string $middleware_type
     * @return void
     */
    public function middleware($middleware_type) {
        $routes_count = count(self::$routes);
        $recent_route = self::$routes[$routes_count-1] ?? null;
        if(isset($recent_route)) {
            $recent_route["middleware"] = $middleware_type;
            self::$routes[$routes_count-1] = $recent_route;
        }
    }

    /**
     * Exempt a route from a middleware (useful within groups)
     *
     * @param  string $middleware_type
     * @return void
     */
    public function withoutMiddleware($middleware_type) {
        $routes_count = count(self::$routes);

        // Create a delayed task to exempt the current route from a middleware
        $callback = function() use($routes_count, $middleware_type) {
            $recent_route = self::$routes[$routes_count-1] ?? null;
            $middleware_type = is_array($middleware_type) ? $middleware_type : [$middleware_type];
            if(isset($recent_route)) {
                $old_middleware = $recent_route["middleware"];

                // If old middleware is array, remove $middleware_type from it
                if(is_array($old_middleware))
                    $new_middleware = array_diff($old_middleware, $middleware_type);

                // else, old middleware is single string
                else
                    $new_middleware = null;
                $recent_route["middleware"] = $new_middleware;
                self::$routes[$routes_count-1] = $recent_route;
            }
        };
        array_push(self::$tasks_to_run, $callback);
    }

    /**
     * Run delayed tasks
     *
     * @return void
     */
    private static function run_tasks() {
        foreach (self::$tasks_to_run as $task) {
            call_user_func($task);
        }
    }

    /**
     * Group a set of routes with a middleware
     *
     * @param  string $middleware_type
     * @param callback $callback
     * @return void
     */
    public static function group($middleware_type, $callback) {
        // Apply group to a set of routes, starting from the
        // next of the current route, until the number of routes
        // after the callback finish execution
        $start_index = count(self::$routes);
        call_user_func($callback);
        $stop_index = count(self::$routes);

        // Set middleware for grouped routes
        for ($i=$start_index; $i < $stop_index; $i++) { 
            self::$routes[$i]["middleware"] = $middleware_type;
        }

        // Run any delayed tasks which may edit some routes within the group
        self::run_tasks();
    }
}

?>