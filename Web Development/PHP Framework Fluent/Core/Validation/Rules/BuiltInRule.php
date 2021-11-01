<?php

namespace Core\Validation\Rules;
use Core\File\File;

class BuiltInRule {

    /**
     * List of Available rules
     *
     * @var array
     */
    public $available_rules = [
        'required',
        'alphabet',
        'alphadash',
        'alphanumeric',
        'boolean',
        'between',
        'digits',
        'endswith',
        'startswith',
        'stringincludes',
        'file',
        'gt',
        'ls',
        'gte',
        'lte',
        'integer',
        'image',
        'in',
        'max',
        'min',
        'mimes',
        'nullable',
        'numeric',
        'string',
        'unique',
    ];

    /**
     * List of Available rules
     *
     * @var array
     */
    private $message;

    /**
     * Apply rule on a value using a $function name and pass $params to it,
     * report error if value is invalid
     *
     * @param string $attribute
     * @param string $function
     * @param mixed $value
     * @param array $params
     * @return bool
     * 
     * @throws \Exception
     */
    public function passes($attribute, $function, $value, $params=[]) {
        try{
            $is_valid = $this->$function($value, ...$params);
        }
        catch(\Exception $e) {
            throw $e;
        }
        if($is_valid) {
            return true;
        }
        else {
            $this->message = "'$attribute' $this->message.";
            report_error($this->message);
            return false;
        }
    }

    /**
     * Check if a built-in rule exists
     *
     * @param string $rule
     * @return bool
     */
    public function has($rule) {
        return method_exists($this, $rule);
    }

    /**
     * Get validation message
     *
     * @return string
     */
    public function message() {
        return $this->message;
    }

    /**
     * Check if value is required
     *
     * @param mixed $value
     * @return bool
     */
    public function required($value) {
        $this->message = "is required";
        return isset($value) && $value != null;
    }

    /**
     * Check if value is alphabet
     *
     * @param mixed $value
     * @return bool
     */
    public function alphabet($value) {
        $this->message = "must consists of alphabet characters only";
        return ctype_alpha($value);
    }

    /**
     * Check if value is alphanumeric
     *
     * @param mixed $value
     * @return bool
     */
    public function alphanumeric($value) {
        $this->message = "must be an alphanumeric character";
        return ctype_alnum($value);
    }

    /**
     * Check if value is alphabet & allow dashes
     *
     * @param mixed $value
     * @return bool
     */
    public function alphadash($value) {
        $this->message = "only alphabets and dashes(_) are allowed";
        return ctype_alpha(str_replace("_", "", $value));
    }

    /**
     * Check if value is boolean type
     *
     * @param mixed $value
     * @return bool
     */
    public function boolean($value) {
        $this->message = "must be a boolean data type";
        return is_bool($value);
    }

    /**
     * Check if value is digits and consists of a specific length
     *
     * @param mixed $value
     * @param string $sample
     * @return bool
     */
    public function digits($value, $sample) {
        $this->message = "must be " . strlen($sample) . " digits";
        return ctype_digit($value) && strlen($sample) == strlen($value);
    }

    /**
     * Check if value is numeric
     *
     * @param mixed $value
     * @return bool
     */
    public function numeric($value) {
        $this->message = "must be a number";
        return ctype_digit($value);
    }

    /**
     * Check if value is string
     *
     * @param mixed $value
     * @return bool
     */
    public function string($value) {
        $this->message = "must be a string";
        return is_string($value);
    }

    /**
     * Check if value is between a range
     *
     * @param mixed $value
     * @param int $min
     * @param int $max
     * @return bool
     * 
     * @throws \Exception
     */
    public function between($value, int $min, int $max) {
        // This method handles:
        // arrays: check array size if between $min & $max
        // numbers: check number if between $min & $max
        // strings: check if string length is between $min & $max
        // files: check if uploaded file size is between $min,$max

        $this->message = "must be between [$min, $max]";

        if(is_array($value))
            return count($value) > $min && count($value) < $max;
        else if (is_numeric($value)) 
            return $value > $min && $value < $max;
        else if(is_string($value))
            return strlen($value) > $min && strlen($value) < $max;
        else if($value instanceof File)
            return $value->getSize() > $min && $value->getSize() < $max;

        // Handle unknown value data type
        else {
            try{
                return $value > $min && $value < $max;
            }
            catch(\Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * Check if value ends with a substring
     *
     * @param string $value
     * @param string $substring
     * @return bool
     */
    public function endswith(string $value, string $substring) {
        $this->message = "must ends with '$substring'";
        return substr($value, strlen($value)-strlen($substring)) == $substring;
    }

    /**
     * Check if value starts with a substring
     *
     * @param string $value
     * @param string $substring
     * @return bool
     */
    public function startswith(string $value, string $substring) {
        $this->message = "must start with '$substring'";
        return substr($value, 0, strlen($substring)) == $substring;
    }

    /**
     * Check if value includes a substring
     *
     * @param string $value
     * @param string $substring
     * @return bool
     */
    public function stringincludes(string $value, string $substring) {
        $this->message = "must include '$substring'";
        return strpos($value, $substring) !== FALSE;
    }

    /**
     * Check if value is file
     *
     * @param mixed $value
     * @return bool
     */
    public function file($value) {
        $this->message = "must be a file";
        return $value instanceof File;
    }

    /**
     * Check if value is greater than a threshold
     *
     * @param int $value
     * @param int $threshold
     * @return bool
     */
    public function gt(int $value, int $threshold) {
        $this->message = "must be greather than $threshold";
        return $value > $threshold;
    }

    /**
     * Check if value is less than a threshold
     *
     * @param int $value
     * @param int $threshold
     * @return bool
     */
    public function ls(int $value, int $threshold) {
        $this->message = "must be less than $threshold";
        return $value < $threshold;
    }

    /**
     * Check if value is greater than or equal a threshold
     *
     * @param int $value
     * @param int $threshold
     * @return bool
     */
    public function gte(int $value, int $threshold) {
        $this->message = "must be greather than or equal $threshold";
        return $value >= $threshold;
    }

    /**
     * Check if value is less than or equal a threshold
     *
     * @param int $value
     * @param int $threshold
     * @return bool
     */
    public function lte(int $value, int $threshold) {
        $this->message = "must be less than or equal $threshold";
        return $value <= $threshold;
    }

    /**
     * Check if value is integer
     *
     * @param mixed $value
     * @return bool
     */
    public function integer($value) {
        $this->message = "must be an integer";
        return is_int($value);
    }

    /**
     * Check if value is image file
     *
     * @param mixed $value
     * @return bool
     */
    public function image($value) {
        $image_extensions = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp'];
        $this->message = "must be an image of type [" . implode(", ", $image_extensions) ."]";
        return $value instanceof File && in_array($value->getExtension(), $image_extensions);
    }

    /**
     * Check if value is less than a max
     *
     * @param mixed $value
     * @param int $max
     * @return bool
     * 
     * @throws \Exception
     */
    public function max($value, int $max) {
        // This method handles:
        // arrays: check array size if between $min & $max
        // numbers: check number if between $min & $max
        // strings: check if string length is between $min & $max
        // files: check if uploaded file size is between $min,$max
        // Other: check if $value is less than $max

        $this->message = "must be less than $max";
        if(is_array($value))
            return count($value) < $max;
        else if (is_numeric($value)) 
            return $value < $max;
        else if(is_string($value))
            return strlen($value) < $max;
        else if($value instanceof File)
            return $value->getSize() < $max;
        else{
            try{
                return $value < $max;
            }
            catch(\Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * Check if value is larger than a min
     *
     * @param mixed $value
     * @param int $min
     * @return bool
     * 
     * @throws \Exception
     */
    public function min($value, int $min) {
        // This method handles:
        // arrays: check array size if between $min & $max
        // numbers: check number if between $min & $max
        // strings: check if string length is between $min & $max
        // files: check if uploaded file size is between $min,$max
        // Other: check if $value is less than $min

        $this->message = "must be greather than $min";
        if(is_array($value))
            return count($value) > $min;
        else if (is_numeric($value)) 
            return $value > $min;
        else if(is_string($value))
            return strlen($value) > $min;
        else if($value instanceof File)
            return $value->getSize() > $min;
        else{
            try{
                return $value > $min;
            }
            catch(\Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * Check if value is file & has a specific extension
     *
     * @param mixed $value
     * @param array $mimesAsArray
     * @return bool
     */
    public function mimes($value, ...$mimesAsArray) {
        if($this->file($value)){
            $mimesAsString = implode(", ", $mimesAsArray);
            $this->message = "must be a type of [$mimesAsString]";
            return in_array(strtolower($value->getExtension()), $mimesAsArray);
        }
        return false;
    }

    /**
     * Check if value is in an array of items
     *
     * @param mixed $value
     * @param array $array
     * @return bool
     */
    public function in($value, ...$array) {
        $this->message = "must be one of the following values [" . implode(", ", $array) . "]";
        return in_array($value, $array);
    }

    /**
     * Check if value is nullable (not required)
     *
     * @param mixed $value
     * @return bool
     */
    public function nullable($value) {
        // useless .. but works!
        return true;
    }

    /**
     * Check if value is unique in database->table->column
     *
     * @param string $model
     * @return bool
     */
    public function unuqie($model) {
        
    }
}

?>