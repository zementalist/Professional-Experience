<?php

namespace Core\Validation;


class Validator {

    /**
     * Validation errors list
     *
     * @var array
     */
    private static $errors_list = [];

    /**
     * Object to apply built-in rules
     *
     * @var Core\Validation\Rules
     */
    private static $builtInRule;

    /**
     * Apply validation using $rules against $data
     *
     * @param array $data
     * @param array $rules
     * @return void
     */
    public static function make(array $data, array $rules) {
        // There are 3 possible formats of a single rule
        // 1- String:  'required|between:min,max|file|...'
        // 2- Object:  new CustomRule()
        // 3- Array: ['required', 'between:min,max', new CustomRule()]

        // Get temporary request structure to validate data
        // to avoid any user-controlled changes to the original request
        Request::getTempRequest($data);
        self::$builtInRule = new BuiltInRule();

        // Loop over data, apply the set of rules
        // corresponding to each data attribute
        foreach ($rules as $key => $rule_set) {
            $separated_rules = self::divideRule($rule_set);
            foreach ($separated_rules as $rule) {
                self::handleRule($key, $rule);
            }
        }
        // report_error($errors_list);
    }

    /**
     * Divide a rule into micro_rules
     * example: "required|max:2" converted to:
     * ['required', 'max:2']
     *
     * @param string $rule
     * @return array
     * 
     * @throws \Exception
     */
    private static function divideRule($rule) {
        // There are 3 formats for a rule
        // 1- "rule1|rule2|rule3"
        // 2- ["rule1", "rule2", new Rule3()]
        // 3- new Rule1()

        if(is_string($rule)) {
            $rule = str_replace(" ", "", $rule);
            $rule = rtrim(ltrim($rule, "|"), "|"); // remove trailing '|'  // sorry if u got it wrong :)
            return explode("|", $rule);
        }

        // return $rule as it is:   ['required', 'between:a,b', ...]
        else if(is_array($rule)) {
            return $rule;
        }

        // converts Object to [Object];
        else if(is_object($rule)) {
            return [$rule];
        }

        // Invalid rule
        else {
            throw new \Exception("Invalid rule: $rule", 1);
        }
    }

    /**
     * Extract rule name and arguments from a rule
     * example: "between:a,b" => ["between", [a, b]]
     *
     * @param string $rule
     * @return array
     */
    private static function extractFunctionAndParams($rule) {
        $splitted = explode(":", $rule);
        $function = $splitted[0];
        $params = isset($splitted[1]) ? explode(",", $splitted[1]) : [];
        return [$function, $params];
    }

    /**
     * Run a single rule
     *
     * @param string $attribute
     * @param string|Core\Validation\Rule $rule
     * @return bool
     */
    private static function handleRule($attribute, $rule) {
        // Handle 2 types of a rule
        // 1- string: "required", "between:a,b", ...
        // 2- \Rule: new CustomRule(...$params)

        // Grab value
        $value = temprequest()->get($attribute);
        if(is_string($rule)) {
            [$function, $params] = self::extractFunctionAndParams($rule);
            if(self::$builtInRule->has($function)) {
                $is_valid = self::$builtInRule->passes($attribute, $function, $value, $params);
                if(!$is_valid) {
                    $error_message = self::$builtInRule->message();

                    // if a key already exists in error messages, push it as nested array
                    if(isset(self::$errors_list["$attribute"]))
                        array_push(self::$errors_list["$attribute"], $error_message);
                    else
                        self::$errors_list["$attribute"] = [$error_message];
                }
                return $is_valid;
            }

            // Function isn't found in built-in validation rules
            else {
                throw new \Exception("Undefined rule '$rule'", 1);
            }
        }

        // else if rule is instance of Rule (is a custom rule)
        else if($rule instanceof Rule) {
            $is_valid = $rule->passes($attribute, $value);
            if(!$is_valid) {
                $error_message = $rule->message();
                $error_message = str_replace(":attribute", "'$attribute'", $error_message);

                // if a key already exists in error messages, push it as nested array
                if(isset(self::$errors_list["$attribute"]))
                    array_push(self::$errors_list["$attribute"], $error_message);
                else
                    self::$errors_list["$attribute"] = [$error_message];
            }
            return $is_valid;
        }
    }

    /**
     * Get validation errors list
     *
     * @return array
     */
    public static function errors() {
        return self::$errors_list;
    }
}

?>