<?php

namespace Core\Session;

class Session {

    /**
     * Start session for the first time
     *
     * @return int
     */
    public static function start() {
        return session_id() ? session_id() : session_start();
    }

    /**
     * Abort session
     *
     * @return bool
     */
    public static function abort() {
        return session_abort();
    }

    /**
     * Destroy session
     *
     * @return bool
     */
    public static function destroy() {
        return session_id() ? session_destroy() : false;
    }

    /**
     * Get session id
     *
     * @return string
     */
    public static function id() {
        return session_id();
    }

    /**
     * Set a session variable
     *
     * @param  string $key
     * @param mixed $value
     * @return mixed
     */
    public static function set($key, $value) {
        $_SESSION["$key"] = $value;
        return $value;
    }

    /**
     * Check if a key exists in $_SESSION
     *
     * @param  string $key
     * @return bool
     */
    public static function key_exists($key) {
        return isset($_SESSION["$key"]);
    }

    /**
     * Get a value of a session variable
     *
     * @param  string $key
     * @param mixe $default
     * @return mixed
     */
    public static function get($key, $default=null) {
        return $_SESSION["$key"] ?? $default;
    }

    /**
     * Remove a session variable & return its value
     *
     * @param  string $key
     * @return mixed
     */
    public static function remove($key) {
        $value = null;
        if(isset($_SESSION["$key"])){
            $value = $_SESSION["$key"];
            unset($_SESSION["$key"]);
        }
        return $value;
    }

    /**
     * Rename a session variable
     *
     * @param  string $old_key
     * @param string $new_key
     * @return void
     */
    public static function rename($old_key, $new_key) {
        if(isset($_SESSION["$old_key"])) {
            $value = $_SESSION["$old_key"];
            unset($_SESSION["$old_key"]);
        }
    }

    /**
     * Get all session variables
     *
     * @return array
     */
    public static function all() {
        return $_SESSION;
    }
}

?>