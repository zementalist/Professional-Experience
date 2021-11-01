<?php

namespace Core\View;

class View {

    /**
     * Context data
     *
     * @var array
     */
    protected $_data = []; // context

    /**
     * HTML template
     *
     * @var string
     */
    private $content; // HTML template

    /**
     * View path
     *
     * @var string
     */
    public $path;

    /**
     * Construct the View object
     *
     * @param string $path
     * @param array $context
     * @return void
     */
    public function __construct($path, array $context=[]) {
        $this->make($path, $context);
    }

    /**
     * Represent $this view content as a string when needed
     *
     * @return string
     */
    public function __toString() {
        return $this->content;
    }

    /**
     * Get data from the request
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name) {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * Render HTML & Register the context
     *
     * @param  string $path
     * @param array $context
     * @return View
     */
    public function make($path, array $context=[]) {
        // Globalize $errors array (found in autoload.php)
        global $errors;

        // Initialize instance properties
        $this->_data = $context;
        $this->path = $path;
        $path = ltrim(rtrim($path, '/'), '/');
        $path = str_replace(".", "/", $path); // allow dev to use '.' same as '/'

        // Initialize context data
        foreach($this->_data as $key => $value) {
            $$key = $value;
        }

        // Render view
        ob_start();
        include("Resources/Views/$path.php");
        $var=ob_get_contents(); 
        ob_end_clean();
        $this->content = $var;
        return $this;
    }

    /**
     * Add errors to $errors array & Re-render View
     *
     * @param  array $arrayOfErrors
     * @return View
     */
    public function withErrors(array $arrayOfErrors) {
        global $errors;
        array_push($errors, ...$arrayOfErrors);
        return $this->make($this->path);
    }

    /**
     * Add context to view & Re-render
     *
     * @param  array $context
     * @return View
     */
    public function with(array $context) {
        return $this->make($this->path, $context);
    }
}

?>