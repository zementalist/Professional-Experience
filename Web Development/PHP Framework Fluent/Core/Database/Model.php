<?php

namespace Core;

use Core\QueryBuilder as Query;

use ArrayAccess;
use JsonSerializable;

abstract class Model implements JsonSerializable, ArrayAccess {

    use Fluent;
    
    /**
     * Table name
     *
     * @var string
     */
    protected $table;

    /**
     * Primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if $this instance exists in the database
     *
     * @var bool
     */
    private $exists = false;

    /**
     * Auto increment field name
     *
     * @var string
     */
    protected $auto_increment_column;

    /**
     * The available columns which came with $this instance
     *
     * @var array
     */
    private $selected_columns = [];

    /**
     * Name of a related table (used for join)
     *
     * @var string
     */
    private $synced_related_table;
    
    /**
     * Data, Keys and values of a single row in the table
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Original (untouched) $attributes
     *
     * @var array
     */
    protected $original = [];

    /**
     * Allowed columns to store data
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Columns which cannot be inserted into
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Columns (keys) which are hidden from $this $attributes
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationships to be auto-eager-loaded
     *
     * @var array
     */
    protected $with = [];

    /**
     * Relationships to be manual-eager-loaded
     *
     * @var array
     */
    private static $eager_lodable = [];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    public const CREATED_AT = null;

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    public const UPDATED_AT = null;


    /**
     * Construct a new instance of a model
     *
     * @return void
     */
    function __construct() {
        
        $this->setTableName();
        $this->setDefaultPrimaryKeyName();
        $this->makeHidden($this->hidden);
           
    }

    /**
     * Set default primary key name if not set in children classes
     *
     * @return string
     */
    private function setDefaultPrimaryKeyName() {
        // Set primaryKey to 'id' if column 'id' exists && this->primaryKey is NOT manually set
        if(!isset($this->primaryKey)) {
            $this->primaryKey = "id";
        }
        return $this->primaryKey;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }

    /**
     * Set auto increment column name
     *
     * @param  string  $column_name
     * @return void
     */
    public function setAutoIncrementColumn($column_name) {
        $this->auto_increment_column = $column_name;
    }

    /**
     * Get auto-increment column name
     *
     * @return string
     */
    public function getAutoIncrementColumn() {
        return $this->auto_increment_column;
    }

    /**
     * Set table name if not set by child class
     *
     * @return string
     */
    public function setTableName() {
        if(isset($this->table))
            return $this->table;
        $this->table = $this->getTableNameFromClass();
        return $this->table;
    }

    /**
     * Set $selected_columns with the columns mentioned in SQL query
     *
     * @param  array  $value
     * @return void
     */
    public function setSelectedColumns($columns=[]) {
        $this->selected_columns = $columns;
    }

    /**
     * Set meta attributes (data which describe the object)
     *
     * @param  array  $meta_columns
     * @return void
     */
    public function setMetaColumns(array $meta_columns) {
        foreach ($meta_columns as $column => $value) {
            if(isset($value)) {
                $this->{$column} = $value;
            }
        }
    }

    /**
     * Predict table name from class name, or other custom class name
     *
     * @param  string  $className
     * @param bool $pluralize
     * @return string
     */
    private function getTableNameFromClass($className = null, $pluralize=true) {
        $className = $className ?? get_called_class();
        $className = substr($className, strrpos($className, "\\")+1);
        $classNameDivided = [];

        // Separate CamelCaseWords
        preg_match_all("/[A-Z][a-z]+/", $className, $classNameDivided);
        $classNameDivided = $classNameDivided[0];
        if($pluralize)
            $classNameDivided[count($classNameDivided)-1] = \Core\Str::pluralize($classNameDivided[count($classNameDivided)-1]);
        
        // Convert_class_name_into_underscore_separated_words
        $tableName = implode("_", $classNameDivided);
        $tableName = strtolower($tableName);
        return $tableName;
    }

    /**
     * Get table name (statically)
     *
     * @return string
     */
    public static function staticGetTableName() {
        $className = new static();
        $obj = new $className;
        return $obj->setTableName();   
    }

    /**
     * Get primary key name (statically)
     *
     * @return string
     */
    public static function staticGetPrimaryKey() {
        $className = new static();
        $obj = new $className;
        return $obj->getPrimaryKey();   
    }

    /**
     * Get primary key name
     *
     * @return string
     */
    public function getPrimaryKey() {
        return $this->primaryKey;
    }

    /**
     * Get child class name
     *
     * @return string
     */
    public static function getModelNameWithoutNameSpace() {
        $className = static::class;
        return substr($className, strrpos($className, "\\")+1);
    }

    /**
     * Push key:value to original data of $this
     *
     * @param  string  $value
     * @param mixed $value
     * @return Model
     */
    public function push_to_original($key, $value) {
        $this->original["$key"] = $value;
        return $this;
    }

    /**
     * Hide key:value pair from $this data
     *
     * @param  string  $column
     * @return Model
     */
    public function makeHidden($columns) {
        $columns = is_array($columns) ? $columns : [$columns];
        $this->attributes = array_diff_key($this->attributes, array_flip((array) $columns));
        return $this;
    }

    /**
     * Un-hide key:value pair in $this data
     *
     * @param  mixed  $columns
     * @return Model
     */
    public function makeVisible($columns) {
        // Function to hide specific columns
        $columns = is_array($columns) ? $columns : [$columns];
        $key_values_to_add = array_intersect_key($this->original, array_flip((array) $columns));
        $this->attributes = array_merge($this->attributes, $key_values_to_add);
        return $this;
    }

    /**
     * Check if a column is hidden from $this dat
     *
     * @param  string  $columnName
     * @return bool
     */
    public function isHidden($columnName) {
        return array_search($columnName, $this->hidden) !== FALSE;
    }


    /**
     * Set existance flag to true
     *
     * @return void
     */
    public function setAsExists() {
        $this->exists = true;
    }

    /**
     * Push array of relations to $eager_loadable
     *
     * @param  array  $data
     * @return void
     */
    public static function push_to_eager_loadable(array $data) {
        array_push(self::$eager_lodable, ...$data);
    }

    /**
     * Eager load relation(s)
     *
     * @param  string|array  $relations
     * @return Model
     */
    public function load($relations) {
        $relations = is_array($relations) ? $relations : [$relations];
        foreach ($relations as $relationName) {
            if(method_exists($this, $relationName))
                $this->$relationName;
            else {
                throw new Exception("Relation '$relationName' is not defined", 1);
            }
        }
        return $this;
    }
    
    /**
     * Return a comma separated string of $selected_columns names
     *
     * @return string
     */
    private function getSelectedColumnsStatement() {
        $text = "";
        $counter=1;
        $column_count = count($this->selectedColumns);
        foreach ($this->selectedColumns as $column) {
            $text .= "$this->table.$column" . ($counter == $column_count ? '' : ', ');
        }
        return $text;
    }

    /**
     * Get selected columns with table name as prefix to each
     *
     * @return array
     */
    public function getSelectedColumns() {
        $columns = [];
        foreach ($this->selected_columns as $column) {
            array_push($columns, "$this->table.$column");
        }
        return $columns;
    }
    
    /**
     * Create new Model instance with attributes retrieved from Database
     *
     * @param  array  $attributes
     * @return Model
     */
    public static function newInstance(array $attributes) {
        // Method to create new instance of this model
        $that = new static;
        foreach ($attributes as $key => $value) {
            $that = $that->push_to_original($key, $value);
            if($that->isHidden($key))
                continue;
            $that["$key"] = $value;
        }
        self::handleAutoIncrementAttribute($that);
        $that->setSelectedColumns(array_keys($attributes));
        $that->setAsExists();
        return $that;
    }

    /**
     * Set auto increment field name if exists
     *
     * @param  Model $instance
     * @return void
     */
    private static function handleAutoIncrementAttribute($instance) {
        $primaryKey = $instance->getPrimaryKey();
        if(isset($instance['auto_increment_id'])){
            $instance->rename_key('auto_increment_id', $primaryKey);
            $instance->setAutoIncrementColumn($primaryKey);
        }
    }

    /**
     * Auto-load relationships mentioned in $with
     *
     * @return void
     */
    public function autoloadWith() {
        // Load relations in $with & $eager_lodable
        $relations = array_merge($this->with, self::$eager_lodable);
        $this->load($relations);
        self::$eager_lodable = [];
    }

    /**
     * Add relation(s) to $eager_loadable & initiate query
     *
     * @param  string|array  $relations
     * @return Query
     */
    public static function with($relations) {
        self::$eager_lodable = is_array($relations) ? $relations : [$relations];
        return self::select();
    }

    /**
     * Create new instance of model with insertion into Database
     *
     * @param  array  $data
     * @return Model
     */
    public static function create($data) {
        $result = static::insert($data);
        $model_instance = static::newInstance($result);
        return $model_instance;
    }

    /**
     * Save $this model's data to Database (either insert OR update)
     *
     * @return Model
     */
    public function save() {
        if($this->exists){
            $new_attributes = array_diff($this->attributes, $this->original);
            $success = static::where($this->primaryKey, $this["$this->primaryKey"])->update($new_attributes, $this->UPDATED_AT);
            if($success)
                $this->original = array_merge($this->original, $this->attributes);
            return $this;
        }
        else
            $instance = static::create($this->attributes);
       return $instance;
    }

    /**
     * Delete row from database
     *
     * @return bool
     * 
     * @throws \Exception
     */
    public function delete() {
        if(isset($this->attributes["$this->primaryKey"]))
            return self::where($this->primaryKey, $this->attributes["$this->primaryKey"])->delete();
        else {
            $className = get_called_class();
            throw new \Exception("There's no unique key for this row to use it for 'delete', use $className::where(some condition)->delete() instead", 1);
        }
    }

    /**
     * Return primary key name if exists, else return 'id'
     *
     * @return string
     */
    private function getPrimaryKeyOrDefault() {
        return ($this->primaryKey ? $this->primaryKey : "id");
    }

    /**
     * Predict foreign key name, given table name
     *
     * @param  string  $class_name
     * @param bool $self
     * @return string
     */
    private function predictForeignKeyName($class_name, $self=false) {
        $model_name = $this->getTableNameFromClass($class_name, false);
        if($self)
            $key = $this->getPrimaryKeyOrDefault();
        else
            $key = "id";
        
        $foreign_key = $model_name . "_" . $key;
        return $foreign_key;
    }

    /**
     * Predict pivot table (bridge table in many-2-many case) name
     *
     * @param  string  $second_table_class
     * @return string
     */
    private function predictPivotTableName($second_table_class) {
        $first_table_name = $this->getTableNameFromClass(get_class($this), true);
        $second_table_name = $this->getTableNameFromClass($second_table_class, true);
        $names_as_array = [$first_table_name, $second_table_name];
        sort($names_as_array);
        return implode("_", $names_as_array);
    }



    /**
     * Set-up a one-to-many relationship
     *
     * @param  string  $second_table_class
     * @param string $foreign_key
     * @param string $owner_key
     * @return Query
     */
    protected function belongsTo($second_table_class, $foreign_key=null, $owner_key=null) {
        $foreign_key = $foreign_key ?? $this->predictForeignKeyName($second_table_class);
        $owner_key = $owner_key ?? $this->getPrimaryKeyOrDefault();
        $ownerKeyValue = $this->{$owner_key} ?? 0;
        $query_builder_instance = self::select($this->getSelectedColumns())
            ->join($second_table_class, $owner_key, $foreign_key)
            ->where("$this->table.$owner_key", $ownerKeyValue);  
        $this->synced_related_table = $second_table_class;
        return $query_builder_instance;
    }

    /**
     * Set-up many-to-one relationship
     *
     * @param  string  $second_table_class
     * @param string $foreign_key
     * @param string $local_key
     * @return mixed
     */
    protected function hasMany($second_table_class, $foreign_key=null, $local_key=null) {
        $foreign_key = $foreign_key ?? $this->predictForeignKeyName($second_table_class);
        $local_key = $local_key ?? $this->getPrimaryKeyOrDefault();
        $localKeyValue = $this->{$local_key} ?? 0;
        $query_builder_instance = self::select($this->getSelectedColumns())
            ->join($second_table_class, $local_key, $foreign_key)
            ->where("$this->table.$local_key", $localKeyValue);  
        $query_builder_instance->enableNestedArrays();
        $this->synced_related_table = $second_table_class;
        return $query_builder_instance;
    }

    /**
     * Get the result of relationship & append it to $this instance
     *
     * @param  Query  $query
     * @param string $relation_name
     * @return Model
     */
    private function handle_relation_query($query, $relation_name) {
        // $relation_name is the name of the method which called the relation

        $instances = $query->get();
        if($instances) {
            $related_instance_key_name = strtolower($this->synced_related_table::getModelNameWithoutNameSpace());
            $related_instance = $instances[0]["$related_instance_key_name"];
            $this["$relation_name"] = $related_instance;
            $this->original["$relation_name"] = $related_instance;
        }
        return $related_instance ?? [];
    }

    /**
     * Set-up many-to-many relationship
     *
     * @param  string  $second_table_class
     * @param string $pivot_table
     * @param string $first_table_foreign_key
     * @param string $second_table_foreign_key
     * @return Query
     */
    protected function belongsToMany($second_table_class, $pivot_table=null, $first_table_foreign_key=null, $second_table_foreign_key=null) {
        $pivot_table_name = $pivot_table ?? $this->predictPivotTableName($second_table_class);
        $second_table_primary_key = $second_table_class::staticGetPrimaryKey();
        $second_table_foreign_key = $second_table_foreign_key ?? $this->predictForeignKeyName($second_table_class);
        $first_table_foreign_key = $first_table_foreign_key ?? $this->predictForeignKeyName(get_class($this), true);
        $first_table_primary_key = $this->getPrimaryKeyOrDefault();
        $first_table_primary_key_value = $this->{$first_table_primary_key} ?? 0;
        $query_builder_instance = self::select($this->getSelectedColumns())
            ->join($pivot_table_name, $first_table_primary_key, $first_table_foreign_key)
            ->join($second_table_class, $second_table_foreign_key, $second_table_primary_key)
            ->where("$this->table.$first_table_primary_key", $first_table_primary_key_value);
        $this->synced_related_table = $second_table_class;
        return $query_builder_instance;
    }

    /**
     * Set-up one-to-one relationship
     *
     * @param  string  $second_table_class
     * @param string $foreign_key
     * @param string $local_key
     * @return Query
     */
    protected function hasOne($second_table_class, $foreign_key, $local_key) {
        $foreign_key = $foreign_key ?? $this->predictForeignKeyName($second_table_class);
        $local_key = $local_key ?? $this->getPrimaryKeyOrDefault();
        $localKeyValue = $this->{$local_key} ?? 0;
        $query_builder_instance = self::select($this->getSelectedColumns())->join($second_table_class, $local_key, $foreign_key)->where("$this->table.$local_key", $localKeyValue);  
        $this->synced_related_table = $second_table_class;
        return $query_builder_instance;
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
     * Override getters
     *
     * @param  string  $property
     * @return mixed
     */
    public function __get($property) {
        if($this->isHidden($property) || $property == $this->primaryKey) {
            return $this->original["$property"];
        }
        else if(isset($this->attributes["$property"])) {
            return $this->attributes["$property"];
        }
        else if(method_exists($this, $property)) {
            $query_builder_instance = $this->$property();
            return $this->handle_relation_query($query_builder_instance, $property);
            $this->synced_related_table = null;
        }
        return null;
    }

    /**
     * Override setters
     *
     * @param  string  $property
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value) {
        if($this->isHidden($property)) {
            $this->original["$property"] = $value;
        }
        $this->attributes["$property"] = $value;
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
     * Handle json_encode behavior with any instance of this class
     *
     * @return array
     */
    public function jsonSerialize() {
        return $this->attributes;
    }

}
?>