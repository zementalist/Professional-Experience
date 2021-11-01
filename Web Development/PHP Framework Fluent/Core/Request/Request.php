<?php
namespace Core\Request;

use Core\Validation\Validator;
use Core\File\UploadedFile;

class Request {

    /**
     * HTTP Request Method
     *
     * @var string
     */
    private $method;

    /**
     * HTTP Request Content-Type
     *
     * @var string
     */
    private $contentType;

    /**
     * HTTP Request Accept
     *
     * @var string
     */
    private $accept;

    /**
     * HTTP Request files (if any)
     *
     * @var array
     */
    private $files = [];

    /**
     * HTTP Request payload
     *
     * @var array
     */
    private $data;

    /**
     * HTTP Methods which contain a body
     *
     * @var array
     */
    private $methods_with_body = ["POST", "PUT", "PATCH", "DELETE"];

    /**
     * Instance of the current HTTP request for static access
     *
     * @var Request
     */
    public static $request;

    /**
     * Temporary instance of Request, used for validation
     *
     * @var Request
     */
    public static $tempRequest;

    /**
     * Construct the request with the payload & headers
     *
     * @param  array $route
     * @param array $url_data
     * @return void
     */
    public function __construct($route, $url_data=[]) {
        $this->method = $route['method'];
        $this->contentType = $_SERVER["CONTENT_TYPE"] ?? "";
        $this->accept = $_SERVER["HTTP_ACCEPT"] ?? "";
        $this->data = $url_data;
        $this->appendData();
        self::$request = $this;
    }

    /**
     * Get a second instance of Request (used to allow validation of any data other than HTTP Request data)
     *
     * @param  array $data
     * @return Request
     */
    public static function getTempRequest($data=[]) {
        $request = new Request(['method' => ""], $data);
        self::$tempRequest = $request;
        return self::$tempRequest;
    }

    /**
     * Append HTTP request data into this instance
     *
     * @return bool
     */
    private function appendData() {
        // If request method has a body
        if(array_search($this->method, $this->methods_with_body) !== FALSE) {
            
            // If request content type is form-data
            if(strpos($this->contentType, "multipart/form-data") !== FALSE) {
                foreach($_FILES as $key => $file) {
                    $this->files["$key"] = new UploadedFile($file);
                }
                foreach($_REQUEST as $key => $value) {
                    $this->data["$key"] = $value;
                }
            }

            // else if request content type is url-encoded
            else if(
                strpos($this->contentType, "application/x-www-form-urlencoded") !== FALSE
                ) 
            {
                $dataArr = $_POST;
                foreach($dataArr as $key => $value) {
                    $this->data["$key"] = $value;
                }
            }

            // else if request content type is JSON encoded
            else if(
                strpos($this->contentType, "application/json") !== FALSE
            ) 
            {
                $json = file_get_contents("php://input");
                $dataArr = json_decode($json, true);
                foreach($dataArr as $key => $value) {
                    $this->data["$key"] = $value;
                }
            }

            // else, request content type is not one of the previously mentioned
            else {
                try{
                    foreach($_REQUEST as $key => $value) {
                        $this->data["$key"] = $value;
                    }
                }
                catch(\Exception $e) {
                    throw new \Exception($e->getMessage(), 1);
                }
            }
        }

        // else if request methodd is GET
        else if($this->method == "GET") {
            array_push($this->data, ...$_GET);
        }

        // else, any other HTTP Request not mentioned, pass it
        else {
            return true;
        }
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function method() {
        return $this->method;
    }

    /**
     * Get data from the request
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key) {
        return $this->data["$key"] ?? null;
    }

    /**
     * Get data from the request
     *
     * @param  string $key
     * @return mixed
     */
    public function input($key) {
        return $this->get($key);
    }

    /**
     * Get all data & files of the request
     *
     * @return array
     */
    public function all() {
        return array_merge($this->data, $this->files);
    }

    /**
     * Get a file from the request (if any)
     *
     * @param  string $key
     * @return Core\File\UploadedFile
     */
    public function file($key){
        return $this->files["$key"] ?? null;
    }

    /**
     * Get an instance of Request with all the data except some
     *
     * @param  array|string $attributes
     * @return Request
     */
    public function except($attributes) {
        $attributes = is_array($attributes) ? $attribute : [$attributes];
        $that = clone $this;
        foreach ($attributes as $attribute) {
            if($that->get($attribute) != null)
                unset($that->data["$attribute"]);
            else if($that->files($attribute) != null)
                unset($that->files["$attribute"]);
        }
        return $that;
    }

    /**
     * Get an instance of Request with all the data except some
     *
     * @param  array|string $attributes
     * @return Request
     */
    public function only($attributes) {
        $attributes = is_array($attributes) ? $attributes : [$attributes];
        $that = clone $this;
        foreach ($that->all() as $attribute => $value) {
            if(array_search($attribute, $attributes) === FALSE){
                if($that->get($attribute) != null)
                    unset($that->data["$attribute"]);
                else if($that->files($attribute) != null)
                    unset($that->files["$attribute"]);
            }
        }
        return $that->all();
    }

    /**
     * Check if request accept type is JSON
     *
     * @return bool
     */
    public function wantsJson() {
        return $this->accept == "application/json";
    }

    /**
     * Run a validation against $this Request's data
     *
     * @param  array $rules
     * @return bool
     * 
     * @throws \Exception
     */
    public function validate($rules) {
        return Validator::make($this->all(), $rules);
    }

    /**
     * Get the current Request (statically)
     *
     * @return Request
     */
    public static function getRequest() {
        return self::$request;
    }
}

?>