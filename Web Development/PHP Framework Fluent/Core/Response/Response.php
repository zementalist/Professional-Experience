<?php

namespace Core\Response;

class Response {

    /**
     * Return a JSON response
     *
     * @param  array $data
     * @param int $status
     * @return string
     */
    public static function json($data, $status=200) {
        $protocol_version = $_SERVER["SERVER_PROTOCOL"];
        header('Content-type:application/json;charset=utf-8');
        header("$protocol_version $status", false, $status);
        return json_encode($data);
    }

    /**
     * Return a redirect response
     *
     * @param  string $to
     * @param int $status
     * @return void
     */
    public static function redirect($to, $status=302) {
        $app_name = env("APP_NAME");
        $base_url = url() . ($app_name ? "/$app_name" : "");
        $clean_path = rtrim(ltrim($to, "/"), "/"); // remove first and last '/' if exist
        $full_path = "$base_url/$clean_path";
        header("Location:$full_path", true, $status);
        return;
    }
}

?>