<?php

namespace Core\Cryptography;

class Hash {
 
    /**
     * Hash a string
     *
     * @param  string
     * @return string
     */
    public static function make($string) {
        $password = password_hash($string, PASSWORD_DEFAULT);
        return $password;
    }

    /**
     * Verify if a hash corresponds to a string
     *
     * @param  string $password
     * @param string $hashedString
     * @return bool
     */
    public static function verify($password, $hashedString) {
        return password_verify($password, $hashedString);
    }
}

?>