<?php

namespace Core\File;

class UploadedFile extends File {

    /**
     * File temporary path
     *
     * @var string
     */
    private $tmp_name;

    /**
     * Default storage path
     *
     * @var string
     */
    private $defaultStoragePath = "/Storage/public/";

    /**
     * Construct file using an object from $_FILES
     *
     * @param  array
     * @return void
     * @throws \Exception
     */
    public function __construct($data) {
        if($data['error'] === 0) {
            $this->name = $this->extractName($data['name']);
            $this->size = $data['size'];
            $this->tmp_name = $data['tmp_name'];
            $this->extension = pathinfo($this->name, PATHINFO_EXTENSION);
        }
        else {
            throw new \Exception("File upload error", 1);
        }
    }

    /**
     * Extract file name without extension
     *
     * @param  $name
     * @return string
     */
    private function extractName(string $name)
    {
        $originalName = str_replace('\\', '/', $name);
        $pos = strrpos($originalName, '/');
        $originalName = false === $pos ? $originalName : substr($originalName, $pos + 1);

        return $originalName;
    }

    /**
     * Store file to specific path on the server
     *
     * @param  string $path
     * @param string $filename
     * @return bool
     */
    public function store($path=null, $filename=null) {
        $path =  ($path ?? $this->defaultStoragePath);
        $clean_path = rtrim(ltrim($path, "/"), "/"); // remove first and last '/' if exist
        $full_path =  __DIR__."/../$clean_path";
        $filename = $filename ?? $this->name;
        $this->mkdir_if_not_exist($full_path);
        try{
            $success = move_uploaded_file($this->tmp_name,"$full_path/$filename");
        }
        catch(\Exception $e) {
            throw $e;
        }
        finally {
            return $success;
        }
    }
}

?>