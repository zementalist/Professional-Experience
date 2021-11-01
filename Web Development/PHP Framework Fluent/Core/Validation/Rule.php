<?php

namespace Core\Validation;

abstract class Rule {
    
    /**
     * Apply the logic of the rule
     *
     * @param  string $attribute
     * @param mixed $value
     * @return bool
     */
    protected abstract function passes($attribute, $value);

    /**
     * Message to display in case of invalid value
     *
     * @return string
     */
    protected abstract function message();

}

?>