<?php

// The basic data structure for data components of the system

namespace Core\Structure;

use ArrayAccess;
use JsonSerializable;

class Assembly implements JsonSerializable, ArrayAccess {

    /**
     * Data items
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Original data items
     *
     * @var array
     */
    protected $original = [];

    /**
     * Valid relational operators, used for conditional selection
     *
     * @var array
     */
    private $valid_relational_operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=',
        // 'like', 'not like', 'ilike',
        // 'not ilike', 'regexp', 'not regexp'
    ];

    /**
     * Construct the data structure
     *
     * @param  array $data
     * @return void
     */
    public function __construct(array $data) {
        $this->attributes = $this->getArrayableItems($data);
        $this->original = clone $this->attributes;
    }

    /**
     * Convert indexed array into associative array (if it's not associative already)
     *
     * @param  array $data
     * @return array
     */
    public function getArrayableItems(array $data) {
        $keys = array_keys($data);
        if(count($keys) > 0) {
            $keys = range(0 ,count($data)-1);
            $data = array_combine($keys, $data);
        }
        return $data;
    }

    /**
     * Get all data
     *
     * @return array
     */
    public function attributes() {
        return $this->attributes;
    }

    /**
     * Rename a key
     *
     * @param  string $old_name
     * @param string $new_name
     * @return void
     */
    public function rename_key($old_name, $new_name) {
        if(isset($this->attributes["$old_name"])){
            $this->attributes["$new_name"] = $this->attributes["$old_name"];
            $this->original["$new_name"] = $this->original["$old_name"];
            unset($this->attributes["$old_name"]);
            unset($this->original["$old_name"]);
        }
    }
    
    /**
     * Get a specific portion of the data
     *
     * @param  array|string $subAttributes
     * @return Assembly
     */
    public function only($subAttributes) {
        $subAttributes = is_array($subAttributes) ? $subAttributes : [$subAttributes];
        $that = clone $this;
        foreach ($this->attributes as $originalAttribute => $value) {
            if(array_search($originalAttribute, $subAttributes) === FALSE){
                unset($that->attributes["$originalAttribute"]);
            }
        }
        return $that;
    }

    /**
     * Add key:value pair to original data
     *
     * @param  string $key
     * @param mixed $value
     * @return Assembly
     */
    public function push_to_original($key, $value) {
        $this->original["$key"] = $value;
        return $this;
    }

    /**
     * Merge data attributes and $original data, store the result in $original
     *
     * @param  array $attributes
     * @return Assembly
     */
    protected function union_with_original($attributes=null) {
        $this->original = array_merge($this->original, $attributes ?? $this->attributes);
        return $this;
    }

    /**
     * Get all data attributes except some
     *
     * @param  array|string $subAttributes
     * @return Assembly
     */
    public function except($subAttributes) {
        $subAttributes = is_array($subAttributes) ? $subAttributes : [$subAttributes];
        $that = clone $this;
        foreach ($subAttributes as $attribute) {
            if(array_search($attribute, $this->attributes) !== FALSE){
                unset($that->all()["$attribute"]);
            }
        }
        return $that;
    }

    /**
     * Push key:value pair into $attributes
     *
     * @param  string $key
     * @param mixed $value
     * @return Assembly
     */
    public function push_key($key, $value) {
        // If key already exists, convert its value to array
        // and push the new value
        if(isset($this->attributes["$key"])) {
            if(is_array($this->attributes["$key"]))
                array_push($this->attributes["$key"], $value);
            else{
                $this->attributes["$key"] = [$this->attributes["$key"]];
                array_push($this->attributes["$key"], $value);
            }
        }

        // else, the key doesn't exist, create it 
        // and set its value
        else {
            $this->attributes["$key"] = $value;
        }
        $this->union_with_original();
        return $this;
    }

    /**
     * Hide some data attributes from the instance
     *
     * @param  array|string $attributes
     * @return Assembly
     */
    public function makeHidden($attributes) {
        $attributes = is_array($attributes) ? $attributes : [$attributes];
        $this->attributes = array_diff_key($this->attributes, array_flip((array) $attributes));
        return $this;
    }

    /**
     * Show (un-hide) some data attributes of the instance
     *
     * @param  array|string $attributes
     * @return Assembly
     */
    public function makeVisible($attributes) {
        $attributes = is_array($attributes) ? $attributes : [$attributes];
        $key_values_to_add = array_intersect_key($this->original, array_flip((array) $attributes));
        $this->attributes = array_merge($this->attributes, $key_values_to_add);
        return $this;
    }

    /**
     * Split an array into n chunks
     *
     * @param  int $n
     * @return array
     */
    public function chunk($n) {
        return array_chunk($this->attributes,$n);
    }

    /**
     * Return the values from a single column in the input array
     *
     * @param  string $key
     * @return array
     */
    public function pluck($key) {
        return array_column($this->attributes, $key);
    }

    /**
     * Returns an associative array of values from array as keys and their count as value.
     *
     * @return array
     */
    public function value_counts() {
        return array_count_values($this->attributes);
    }

    /**
     * Convert multi-dimensionl array into 1D array
     *
     * @param  int $depth
     * @param array $items
     * @return array
     */
    public function flatten($depth=-1, $items=[]) {
        $values = [];
        if(is_array($items)) {
            $new_items = array_values($items);
            flatten(-1, $new_items);
        }
    }

    /**
     * Applies a callback to the elements of the given array
     *
     * @param  callback $callback
     * @return Assembly
     */
    public function map($callback) {
        return new self(array_map($callback, $this->attributes));
    }

    /**
     * Get all data attributes
     *
     * @return array
     */
    public function all() {
        return $this->attributes;
    }

    /**
     * Merge another \Assembly to $this
     *
     * @param  Assembly $assembly
     * @return Assembly
     */
    public function merge(Assembly $assembly) {
        return array_merge($this->attributes, $assembly->all());
    }

    /**
     * Get keys
     *
     * @return array
     */
    public function keys() {
        return array_keys($this->attributes);
    }

    /**
     * Pop the element off the end of the \Assembly
     *
     * @return mixed
     */
    public function pop() {
        return array_pop($this->attributes);
    }

    /**
     * Push one or more elements onto the end of array
     *
     * @param  mixed $items
     * @return void
     */
    public function push(...$items) {
        array_push($this->attributes, ...$items);
    }

    /**
     * Conditional selection of data items
     *
     * @param string $key
     * @param mixed $value
     * @param string $operator
     * @return Assembly
     */
    function where($key, $value, $operator=null) {

        // if where(key, value) .. set operator to '='
        if($operator == null) {
            $operator = "=";
        }

        // else, where(key, operator, value) .. swap function parameters above
        else {
            $tempValue = $operator;
            $operator = $value;
            $value = $tempValue;
        }

        // validate operator, set to '=' if invalid
        $operator_index = array_search(strtolower($operator), $this->valid_relational_operators);
        $operator = $operator_index ? $this->valid_relational_operators[$operator_index] : '=';
        
        // Apply conditional selection
        $filtered = array_filter($this->attributes, function($item) use($key, $operator, $value) {
            $left_hand_side = isset($key) ? $item["$key"] : $item;
            $right_hand_side = $value;
            return eval(" return $left_hand_side $operator $right_hand_side; ");
        });
        $new_assembly = new self($filtered);
        return $new_assembly;
    }

    /**
     * Get Assembly of data between a range
     *
     * @param string $key
     * @param array $range
     * @return Assembly
     */
    public function whereBetween($key, array $range) {
        if(count($range) == 2) {
            $min = $range[0];
            $max = $range[1];
            $filtered = array_filter($this->attributes, function($item) use($key, $min, $max) {
                $value = isset($key) ? $item["$key"] : $item;
                return $value >= $min && $value <= $max;
            });
        }
        $new_assembly = new self($filtered ?? []);
        return $new_assembly;
    }

    /**
     * Get Assembly of data OUTSIDE a range
     *
     * @param string $key
     * @param array $range
     * @return Assembly
     */
    public function whereNotBetween($key, array $range) {
        if(count($range) == 2) {
            $min = $range[0];
            $max = $range[1];
            $filtered = array_filter($this->attributes, function($item) use($key, $min, $max) {
                $value = isset($key) ? $item["$key"] : $item;
                return $value < $min && $value > $max;
            });
        }
        $new_assembly = new self($filtered ?? []);
        return $new_assembly;
    }

    /**
     * Get assembly of data which exists in an array
     *
     * @param string $key
     * @param array $includes
     * @return Assembly
     */
    public function whereIn($key, array $includes) {
        $filtered = array_filter($this->attributes, function($item) use($key, $includes) {
            $value = isset($key) ? $item["$key"] : $item;
            return in_array($value, $includes);
        });
        $new_assembly = new self($filtered);
        return $new_assembly;
    }

    /**
     * Get assembly of data which does NOT exists in an array
     *
     * @param string $key
     * @param array $includes
     * @return Assembly
     */
    public function whereNotIn($key, array $includes) {
        $filtered = array_filter($this->attributes, function($item) use($key, $includes) {
            $value = isset($key) ? $item["$key"] : $item;
            return !in_array($value, $includes);
        });
        $new_assembly = new self($filtered);
        return $new_assembly;
    }

    /**
     * Get assembly of data which does NOT contain a specific key
     *
     * @param  string $key
     * @return Assembly
     */
    public function whereNull($key) {
        $filtered = array_filter($this->attributes, function($item) use($key) {
            return !isset($item["$key"]);
        });
        $new_assembly = new self($filtered);
        return $new_assembly;
    }

    /**
     * Get assembly of data which MUST contain a specific key
     *
     * @param  string $key
     * @return Aassembly
     */
    public function whereNotNull($key) {
        $filtered = array_filter($this->attributes, function($item) use($key) {
            return isset($item["$key"]);
        });
        $new_assembly = new self($filtered);
        return $new_assembly;
    }

    /**
     * Count the data items of the assembly
     *
     * @return int
     */
    public function count() {
        return count($this->attributes);
    }

    /**
     * Get a data item by index
     *
     * @param  int $index
     * @return array
     */
    public function at($index) {
        return [array_keys($this->attributes)[$index] => array_values($this->attributes)[$index]];        
    }

    /**
     * Get first data item
     *
     * @return array
     */
    public function first() {
        if($this->count() == 0)
            return null;
        return [array_keys($this->attributes)[0] => array_values($this->attributes)[0]];
    }

    /**
     * Get last data item
     *
     * @return array
     */
    public function last() {
        $index = $this->count() - 1;
        if($index == -1)
            return null;
        return [array_keys($this->attributes)[$index] => array_values($this->attributes)[$index]];
    }

    /**
     * Remove a portion of the assembly and replace it with something else
     *
     * @param  int $start
     * @param int $stop
     * @param array $replace
     * @return Assembly
     */
    public function splice($start, $stop=null, array $replace=null) {
        $stop = isset($stop) ? $stop : $this->count();
        array_splice($this->attributes, $start, $stop, $replace);
        return $this;
    }

    /**
     * Calculate sum of one or more data attributes
     *
     * @param  string $key
     * @return int
     */
    public function sum($key=null) {
        // If $key is null, assume the data are indexed array
        if(!isset($key)) {
            return array_sum($this->attributes);
        }

        // else $key is set, assume the data are array of associative arrays
        // and calculate the total sum of a specific column
        $total = 0;
        foreach ($this->attributes as $item) {
            if(isset($item["$key"]))
                $total += array_sum($item["$key"]);   
        }
        return $total;
    }

    /**
     * Get every nth data item, starting from index 0 (default)
     *
     * @param  int $n
     * @param int $start
     * @return Assembly
     */
    public function nth($n, $start=0) {
        $items = [];
        for ($i=$start; $i < $this->count() ; $i++) { 
            if($i % $n == 0)
                array_push($items, $this->at($i));   
        }
        return new self($items);
    }

    /**
     * Fill array with a value as a padding,
     * positiv $n corresponds to right padding,
     * negative $n corresponds to left padding.
     *
     * @param  mixed $value
     * @param int $n
     * @return Assembly
     */
    public function pad($value, $n) {
        $padding = array_fill(0, abs($n), $value);
        $array = $n > 0 ? 
            array_merge($this->attributes, $padding) : 
            array_merge($padding, $this->attributes) ;
        $new_assembly = new self($array);
        return $new_assembly;
    }

    /**
     * Represent $this model's data as a string when needed
     *
     * @return string
     */
    public function __toString() {
        return json_encode($this->attributes);
    }
    
    /**
     * Override isset method
     *
     * @param  string  $property
     * @return bool
     */
    public function __isset($property) {
        return isset($this->attributes["$property"]);
    }

    /**
     * Override unset method
     *
     * @param  string  $property
     * @return void
     */
    public function __unset($property) {
        unset($this->attributes["$property"]);
    }

    /**
     * Override getters
     *
     * @param  string  $property
     * @return mixed
     */
    public function __get($property) {
        return $this->attributes["$property"];
    }

    /**
     * Implementation of Arrayable method offsetSet
     *
     * @param  string  $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } 
        else {
            $this->attributes[$offset] = $value;
        }
    }

    /**
     * Implementation of Arrayable method offsetExists
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->attributes[$offset]);
    }

    /**
     * Implementation of Arrayable method offsetUnset
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->attributes[$offset]);
    }

    /**
     * Implementation of Arrayable method offsetGet
     *
     * @param  string  $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null;
    }

    /**
     * Handle json_encode behavior with any instance of this class
     *
     * @return array
     */
    public function jsonSerialize() {
        return $this->attributes;
    }
}


?>