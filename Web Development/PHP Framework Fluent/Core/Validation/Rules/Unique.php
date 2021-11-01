<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule;

class Unique extends Rule {
    
    /**
     * List of parameters
     *
     * @var array
     */
    private array $params;

    /**
     * Construct the rule & register parameters
     *
     * @param  array $params
     * @return void
     */
    public function __construct(...$params) {
        $this->params = $params;
    }

    /**
     * Apply the logic of the rule
     *
     * @param  string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $model = $this->params[0];
        $valueExists = $model::where($attribute, $value)->get();
        return $valueExists ? true : false;
    }

    /**
     * Message to display in case of invalid value
     *
     * @return string
     */
    public function message() {
        return ":attribute must contain the the word 'AnotherRule'";
    }
}

?>