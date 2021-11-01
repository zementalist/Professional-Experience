<?php

namespace Core\File;

class File {
    /**
     * File name
     *
     * @var string
     */
    protected $name;

    /**
     * File Extension
     *
     * @var string
     */
    protected $extension;

    /**
     * File size in bytes
     *
     * @var int
     */
    protected $size;

    /**
     * Get file name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * Get file size
     *
     * @return string
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Create a new directory (or more, recursively) if doesn't exist
     *
     * @param  string $path
     * @return bool
     */
    protected function mkdir_if_not_exist($path) {
        $state = true;
        if(!is_dir($path)) {
           $state= mkdir($path,0777,true);
        }
        return $state;
    }

    /**
     * Delete a file
     *
     * @param string $path
     * @return bool
     */
    public static function delete($path) {
        return unlink($path);
    }

    /**
     * Check if file exists
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path) {
        return is_file($path);
    }
}


?>