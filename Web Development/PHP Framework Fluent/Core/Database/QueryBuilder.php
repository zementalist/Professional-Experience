<?php

namespace Core;

class QueryBuilder {

    /**
     * Valid SQL relational operators
     *
     * @var array
     */
    private $valid_relational_operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    /**
     * Valid SQL logical operators (ignore NOT)
     *
     * @var array
     */
    private $valid_logical_operators = ["or", "and"];

    /**
     * Valid SQL joins
     *
     * @var array
     */
    private $join_types = ["inner", "left", "right", "full"];

    /**
     * The table which the query is working on
     *
     * @var string
     */
    private $table;

    /**
     * Array of tables which the query is working on (important for joins)
     *
     * @var array
     */
    public $tables_in_query = [];

    /**
     * Allow/Prevent nested arrays for complex SQL joins results
     *
     * @var bool
     */
    private $nested_arrays = false;

    /**
     * Name of the model which the query is working with
     *
     * @var string
     */
    private $model_name;
    
    /**
     * Data types of the data to be inserted into a table, used for prepared statements
     *
     * @var string
     */
    private $types = "";

    /**
     * Data to be inserted into a table, used for prepared statements
     *
     * @var array
     */
    private $params = [];

    /**
     * Instance of database connection
     *
     * @var mysqli
     */
    private $conn;

    /**
     * ID of last inserted row
     *
     * @var int
     */
    private $insert_id;

    /**
     * Represents SQL query
     *
     * @var string
     */
    private $query;

    /**
     * Construct a query from scratch
     *
     * @param  string  $modelName
     * @return void
     */
    public function __construct($modelName) {
        $this->conn = Database::getConnection();
        $this->model_name = $modelName;
        $this->table = $this->model_name::staticGetTableName();
        $this->addTableToQueriedTables($this->table, $modelName);
        $this->setDefaultQuery();
    }

    /**
     * Set a default query
     *
     * @return void
     */
    private function setDefaultQuery() {
        $this->query = "SELECT * FROM $this->table";
    }

    /**
     * Clear query & params array after a query execution is finished
     *
     * @return void
     */
    private function clearQuery() {
        $this->setDefaultQuery();
        $this->params = [];
        $this->types = "";
    }

    /**
     * Enable nested arrays for constructing results of complex SQL joins
     *
     * @return void
     */
    public function enableNestedArrays() {
        $this->nested_arrays = true;
    }

    /**
     * Disable nested arrays for constructing results of complex SQL joins
     *
     * @return void
     */
    public function disableNestedArrays() {
        $this->nested_arrays = false;
    }

    /**
     * Add a table name & its class name to $tables_in_query
     *
     * @param  string  $tableName
     * @param string $className
     * 
     * @return void
     */
    private function addTableToQueriedTables($tableName, $className) {
        $this->tables_in_query["$tableName"] = "$className";
    }

    /**
     * Check if a column of a table is a (SQL attribute: Primary key, Auto-Increment, etc..)
     *
     * @param  string  $field
     * @param int $mysqli_flag_number
     * @return int
     */
    private function fieldIs($field, $mysqli_flag_number) {
        return $field->flags & $mysqli_flag_number;
    }

    /**
     * Prepare SQL query
     *
     * @return mysqli_stmt
     */
    private function prepareStmt() {
        $stmt = $this->conn->prepare($this->query);
        if($stmt == false) {
            throw new \Exception(mysqli_error($this->conn), 1);
        }
        return $stmt;
    }

    /**
     * Bind parameters to prepared statement
     *
     * @return mysqli_stmt
     */
    private function bindStmt() {
        if(count($this->params) > 0)
            $stmt->bind_param($this->types, ...$this->params);
        return $stmt;
    }

    /**
     * Handle prepared statement execution result
     *
     * @param  mysqli_stmt  $stmt
     * 
     * @return mysqli_result ? if query is SELECT, SHOW, DESCRIBE, EXPLAIN
     * @return int ? if query is INSERT, UPDATE, DELETE, REPLACE
     */
    private function handleStmtResult($stmt) {
        $result = $stmt->get_result();
        $result = $result ? $result : $stmt->affected_rows;
        $stmt->close();
        $this->clearQuery();
        return $result;
    }

    /**
     * Execute SQL query
     *
     * @return mixed
     */
    private function executeStmt() {
        $stmt = $this->prepareStmt();
        try{
            $stmt = $this->bindStmt();
            $state = $stmt->execute();
        }
        catch(\Exception $e) {
            throw new \Exception(mysqli_error($this->conn), 1);
        }

        // check if execution failed
        if($state === false) 
            throw new \Exception(mysqli_error($this->conn), 1);
        return $this->handleStmtResult($stmt);
    }

    /**
     * Run SQL query & convert mysqli_result into a array of Model object(s)
     *
     * @return array
     */
    public function get() {
        // Execute query & fetch results
        $result = $this->executeStmt();
        $rows_fields = $result->fetch_fields();
        $rows = $result->fetch_all();

        // Initialize the array holding Model object(s)
        $array_of_models = [];
        $array_of_models_counter = 0;

        // Loop over rows of the result
        for($i = 0; $i < count($rows); $i++) {
            $attributes = []; // attributes of current model/table
            $related_attributes = []; // attributes of second table
            $primaryKey = null;
            $auto_increment_field = null;
            $primaryKeyRelated = null;
            $auto_increment_field_related = null;

            // Loop over row columns
            for($j = 0; $j < count($rows[$i]); $j++) {
                $value = $rows[$i][$j];
                $field = $rows_fields[$j];

                // if field is for $this table
                if($field->table == $this->table) {

                    // add key->value to $this table's attributes
                    $attributes["$field->orgname"] = $value;

                    // Set meta information about the column/field
                    $primaryKey = $primaryKey ?? $this->fieldIsPrimaryKey($field);
                    $auto_increment_field = $auto_increment_field ?? $this->fieldIsAutoInc($field);
                }

                // else, field is for related table
                else {

                    // add key->value to related table's attribute
                    $related_model_name = array_values($this->tables_in_query)[count($this->tables_in_query)-1]; //$this->tables_in_query["$field->table"];
                    $related_attributes["$field->orgname"] = $value;

                    // Set meta information about the columm/field
                    $primaryKeyRelated = $primaryKeyRelated ?? $this->fieldIsPrimaryKey($field);
                    $auto_increment_field_related = $auto_increment_field_related ?? $this->fieldIsAutoInc($field);
                }
            }

            // Create new model instance using the extracted row
            $model_instance = $this->model_name::newInstance($attributes);

            // if there are related attributes found in the row
            if(count($related_attributes) > 0) {

                // Create instance of related model with the related data
                $related_model_instance = $related_model_name::newInstance($related_attributes);
                $related_model_instance->setMetaColumns([
                    'primaryKey' => $primaryKeyRelated,
                    'auto_increment_column' => $auto_increment_field_related
                    ]);

                // related table name, will be used as the key name for $this table's related attribute
                $related_model_table_name = strtolower($related_model_instance->getModelNameWithoutNamespace());

                // get previous instance of $this table in array_of_models , or set to null if not exist
                $previous_instance = $array_of_models_counter == 0 ? null : $array_of_models[$array_of_models_counter-1];
                
                // if previous instance exist, then it contains related_table values,
                // add those values to current instance, so we can make a wise comparison
                if(isset($previous_instance))
                    $model_instance = $model_instance->push_key($related_model_table_name, $previous_instance["$related_model_table_name"]);
                
                // if the current instance is the same as previous
                if($model_instance == $previous_instance) {

                    // set the current to previous & remove the previous from the array
                    // so the previous instance is as brand new instance
                    $model_instance = $previous_instance;
                    array_pop($array_of_models);
                    $array_of_models_counter--;
                }

                // else, current instance is different
                else {
                    // unset related table data, because it's for previous, & used for comparison only
                    unset($model_instance["$related_model_table_name"]);
                }

                // add related model data to current model, using the related_model_table_name as the key
                $related_model_instance = $this->nested_arrays ? [$related_model_instance] : $related_model_instance;
                $model_instance = $model_instance->push_key($related_model_table_name, $related_model_instance);
            }
            
            // else, there are no related attributes, just load any auto-load relations
            else {
                $model_instance->autoloadWith();
            }
            
            // Set meta information about the model instance
            $model_instance->setMetaColumns([
                    'primaryKey' => $primaryKey,
                    'auto_increment_column' => $auto_increment_field
                    ]);

            // push instance to array of models
            array_push($array_of_models, $model_instance);
            $array_of_models_counter++;
        }

        // Set $tables_in_query to the default value (Base table)
        $this->tables_in_query = array_slice($this->tables_in_query, 0, 1, true);

        return $array_of_models;
    }

    /**
     * Check if an operator is a valid SQL operator
     *
     * @param  string  $operator
     * @param array $list_of_valid_operators
     * @param bool $throwException
     * @return bool
     * @throws Exception
     */
    private function validate_operator($operator, $list_of_valid_operators, bool $throwException = false) {
        $is_valid = array_search(strtolower($operator), $list_of_valid_operators) !== FALSE;
        if(!$is_valid && $throwException)
            throw new \Exception("Invalid operator '$operator'", 1);
        return $is_valid;
    }

    /**
     * Check if the current SQL query has a WHERE/HAVING clause
     *
     * @return bool
     */
    private function queryHasCondition() {
        return stripos($this->query, "WHERE") !== FALSE || stripos($this->query, "HAVING") !== FALSE;
    }


    /**
     * Check if a column is a primary key
     *
     * @param  object  $field
     * @return string
     */
    public function fieldIsPrimaryKey($field) {
        return $this->fieldIs($field, MYSQLI_PRI_KEY_FLAG) ? $field->orgname : null;
    }

    /**
     * Check if a column is Auto-Increment
     *
     * @param  object  $field
     * @return string
     */
    public function fieldIsAutoInc($field) {
        return $this->fieldIs($field, MYSQLI_AUTO_INCREMENT_FLAG) ? $field->orgname : null;
    }

    /**
     * Prepare eager load
     *
     * @param  array|string  $relations
     * @return Query
     */
    public function with($relations) {
        $class = array_values($this->tables_in_query)[0];
        $relations = is_array($relations) ? $relations : [$relations];
        $class::push_to_eager_loadable($relations);
        return $this;
    }

    /**
     * Extract [column, operator ?, value , logical_operator ?] since any column 
     * may be null except column and value
     *
     * @param  array  $condition
     * @param array $is_last_condition
     * @return array
     */
    private function extract_condition_components(array $condition, bool $is_last_condition) {
        // case 2 : [column, value]
        // case 3.1 : [column, operator, value]
        // case 3.2 : [column, value, logical_op]
        // case 4 : [column, operator, value, logical_op]
        
        $column = $condition[0];
        switch (count($condition)) {
            case 4:
                $operator = $condition[1];
                $value = $condition[2];
                $logical_op = $condition[3];
                break;

            case 3:
                // 3.1  // default logical_operator is 'AND'
                $operator_index_is_1 = $this->validate_operator($condition[1], $this->valid_relational_operators);
                if($operator_index_is_1) {
                    $operator = $condition[1];
                    $value = $condition[2];
                    $logical_op = $is_last_condition ? "" : "AND";
                }
                // 3.2 default operator is '='
                else {
                    $operator = '=';
                    $value = $condition[1];
                    $logical_op = $condition[2];
                }
                break;
            
            // default operator is '=' && default logical-operator is 'AND'
            case 2:
                $value = $condition[1];
                $operator = '=';
                $logical_op = $is_last_condition ? "" : "AND";
                break;
        }

        // Force to remove logical operator if this is the last condition
        $logical_op = $is_last_condition ? "" : $logical_op;

        // Validate relational & logical operators
        $this->validate_operator($operator, $this->valid_relational_operators, true);
        $this->validate_operator($logical_op, $this->valid_logical_operators, true) || $logical_op == "";

        return [$column, $operator, $value, $logical_op];    
    }

    /**
     * Get the id of the last inserted row (if isset)
     *
     * @return int
     */
    public function getInsertId() {
        return $this->insert_id;
    }

    /**
     * Build a SELECT query
     *
     * @param  array  $columns
     * @return Query
     */
    function select($columns=['*']) {
        // Method to select specific columns from all rows in a table
        $columns_to_select = is_string($columns) ? $columns : implode(", ", $columns);
        $old_query_additional_part = substr($this->query, stripos($this->query, "FROM"));
        $this->query = "SELECT $columns_to_select $old_query_additional_part";
        return $this;
    }

    /**
     * Append a WHERE clause to SQL query
     *
     * @param  string|array  $column
     * @param mixed $value
     * @param string $operator
     * @return Query
     */
    function where($column, $value=null, $operator=null) {

        // if where([...]) call multi_where
        if(is_array($column)) {
            return $this->multi_where($column);
        }

        // if where(column, value) .. set operator to '='
        if($operator == null) {
            $operator = "=";
        }
        else if(!isset($value) && !isset($operator))
            throw new \Exception("Few parameters passed to where($column, $value, $operator)", 1);
            
        // else if where(column, operator, value) .. swap function parameters
        else {
            $tempValue = $operator;
            $operator = $value;
            $value = $tempValue;
        }

        // validate operator, set to '=' if invalid
        $operator_index = array_search(strtolower($operator), $this->valid_relational_operators);
        $operator = $operator_index ? $this->valid_relational_operators[$operator_index] : '=';

        $column = mysqli_real_escape_string($this->conn ,$column);

        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column $operator ? ";
        else 
            $this->query = "$this->query AND $column $operator ?";
        
        $this->types .= "s";
        array_push($this->params, $value);
        return $this;
    }

    /**
     * Append a 'OR WHERE' clause to SQL query
     *
     * @param  string  $key
     * @param mixed $value
     * @param string $operator
     * @return Query
     */
    function orWhere($key, $value, $operator=null) {
        
        // if where(column, value) .. set operator to '='
        if($operator == null) {
            $operator = "=";
        }
        // else if where(column, operator, value) .. swap function parameters above
        else {
            $tempValue = $operator;
            $operator = $value;
            $value = $tempValue;
        }

        // validate operator, set to '=' if invalid
        $operator_index = array_search(strtolower($operator), $this->valid_relational_operators);
        $operator = $operator_index ? $this->valid_relational_operators[$operator_index] : '=';

        $key = mysqli_real_escape_string($this->conn ,$key);

        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $key $operator ? ";
        else 
            $this->query = "$this->query OR $key $operator ?";
        
        $this->types .= "s";
        array_push($this->params, $value);
        return $this;
    }

    /**
     * Append multiple 'WHERE' clauses to SQL query
     *
     * @param  array  $array
     * @return Query
     */
    function multi_where($array) {        
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE ";
        else 
            $this->query = "$this->query AND ";
        $counter = 1;
        foreach($array as $condition) {
            $is_last_condition = count($array) == $counter;
            [$key, $operator, $value, $logical_op] = $this->extract_condition_components($condition, $is_last_condition);
            $key = mysqli_real_escape_string($this->conn ,$key);
            $this->query .= " $key $operator ? " . $logical_op;
            $this->types .= "s";
            array_push($this->params, $value);
            $counter++;
        }
        return $this;
    }

    /**
     * Append a 'WHERE X IN Y' clause to SQL query
     *
     * @param  string  $column
     * @param array $values
     * @return Query
     */
    function whereIn($column, array $values) {
        $clause = implode(',', array_fill(0, count($values), '?'));
        $types  = implode('', array_fill(0, count($values), 's'));
        $this->types .= $types;
        array_push($this->params, ...$values);
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IN ($clause) ";
        else 
            $this->query = "$this->query AND $column IN ($clause) ";
        return $this;
    }

    /**
     * Append a 'WHERE X NOT IN Y' to SQL query
     *
     * @param  string  $column
     * @param array $values
     * @return Query
     */
    function whereNotIn($column, array $values) {
        $clause = implode(',', array_fill(0, count($values), '?'));
        $types  = implode('', array_fill(0, count($values), 's'));
        $this->types .= $types;
        array_push($this->params, ...$values);
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column NOT IN ($clause) ";
        else 
            $this->query = "$this->query AND $column NOT IN ($clause) ";
        return $this;
    }

    /**
     * Append a 'OR WHERE X IN Y' to SQL query
     *
     * @param  string  $column
     * @param array $values
     * @return Query
     */
    function orWhereIn($column, array $values) {
        $clause = implode(',', array_fill(0, count($values), '?'));
        $types  = implode('', array_fill(0, count($values), 's'));
        $this->types .= $types;
        array_push($this->params, ...$values);
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IN ($clause) ";
        else 
            $this->query = "$this->query OR $column IN ($clause) ";
        return $this;
    }

    /**
     * Append 'OR WHERE X NOT IN Y' to SQL query
     *
     * @param  string  $column
     * @param array $values
     * @return Query
     */
    function orWhereNotIn($column, $values) {
        $clause = implode(',', array_fill(0, count($values), '?'));
        $types  = implode('', array_fill(0, count($values), 's'));
        $this->types .= $types;
        array_push($this->params, ...$values);
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column NOT IN ($clause) ";
        else 
            $this->query = "$this->query OR $column NOT IN ($clause) ";
        return $this;
    }

    /**
     * Append 'WHERE X IS NULL' to SQL query
     *
     * @param  string  $column
     * @return Query
     */
    function whereNull($column) {
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IS NULL ";
        else 
            $this->query = "$this->query AND $column IS NULL ";
        return $this;
    }

    /**
     * Append 'WHERE X IS NOT NULL' to SQL query
     *
     * @param  string  $column
     * @return Query
     */
    public function whereNotNull($column) {
        // Method to select rows using WHERE column IS NOT NULL
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IS NOT NULL ";
        else 
            $this->query = "$this->query AND $column IS NOT NULL ";
        return $this;
    }

    /**
     * Append 'OR WHERE X IS NULL' to SQL query
     *
     * @param  string  $column
     * @return Query
     */
    public function orWhereNull($column) {
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IS NULL ";
        else 
            $this->query = "$this->query OR $column IS NULL ";
        return $this;
    }

    /**
     * Append 'OR WHERE X IS NOT NULL' to SQL query
     *
     * @param  string  $column
     * @return Query
     */
    public function orWhereNotNull($column) {
        $column = mysqli_real_escape_string($this->conn ,$column);
        if(!$this->queryHasCondition())
            $this->query = "$this->query WHERE $column IS NOT NULL ";
        else 
            $this->query = "$this->query OR $column IS NOT NULL ";
        return $this;
    }

    /**
     * Append a raw `WHERE` clause
     *
     * @param  string  $query
     * @return Query
     */
    function whereRaw($query) {
        $this->query = "$this->query WHERE $query ";
        return $this;
    }

    /**
     * Group rows by a column
     *
     * @param  string  $column
     * @return Query
     */
    function groupBy($column) {
        if(stripos($this->query, "GROUP BY") === FALSE) {
            $this->query = "$this->query GROUP BY $column ";
        }
        return $this;
    }
    
    /**
     * Order rows by a column, ASCending or DESCending
     *
     * @param  string  $column
     * @param string $order
     * @return Query
     */
    function orderBy($column, $order="ASC") {
        // Method to order rows by a column and specific order
        if(stripos($this->query, "ORDER BY") === FALSE) {
            $this->query = "$this->query ORDER BY $column $order";
        }
        return $this;
    }

    /**
     * Order rows DESCending by a column
     *
     * @param  string  $column
     * @return Query
     */
    function latest($column="created_at") {
        // Method to select latest rows, orderd by a column
        return $this->orderBy($column, "DESC");
    }

    /**
     * Order rows ASCending by a column
     *
     * @param  string  $column
     * @return Query
     */
    function oldest($column="created_at") {
        // Method to select oldest rows, orderd by a column
        return $this->orderBy($column, "ASC");
    }

    /**
     * Limit the number of selected rows
     *
     * @param  int  $n_rows
     * @return Query
     */
    function take($n_rows) {
        // Method to LIMIT the number of selected rows
        if(stripos($this->query, "LIMIT") === FALSE) {
            $this->query = "$this->query LIMIT ?";
            $this->types .= 'i';
            array_push($this->params, $n_rows);
        }
        return $this;
    }

    /**
     * Limit the number of selected rows
     *
     * @param  int $n_rows
     * @return Query
     */
    function limit($n_rows) {
        return $this->take($n_rows);
    }

    /**
     * Join TWO tables
     *
     * @param  string $second_table_class
     * @param string $foreign_key
     * @param $primary_key
     * @param $join_type
     * @return Query
     */
    function join($second_table_class, $foreign_key, $primary_key, $join_type="INNER") {
        $second_table_name = class_exists($second_table_class)  ? ($second_table_class::staticGetTableName()) : $second_table_class; 
        $this->addTableToQueriedTables($second_table_name, $second_table_class);

        // Clean keys, validate join type
        $primary_key = mysqli_real_escape_string($this->conn ,$primary_key);
        $foreign_key = mysqli_real_escape_string($this->conn ,$foreign_key);
        $this->validate_operator($join_type, $this->join_types, true);

        // If there is a previous JOIN (so this is multiple-join)
        if(stripos($this->query, "JOIN") !== FALSE && stripos($this->query, "SELECT $second_table_name") === FALSE)
            // Select the joining table.* all columns
            $this->query = "SELECT $second_table_name.*, " . substr($this->query, 6);
    
        // If there is no selection applied previously
        if(stripos($this->query, "SELECT *") !== FALSE)
            // Select all and add a column as a separator between tables
            $this->query = "SELECT $this->table.*,  $second_table_name.* FROM $this->table ";
        
        // If there is no selection applied previously
        if(stripos($this->query, "SELECT $second_table_name") === FALSE)
            // Select all and add a column as a separator between tables
            $this->query = "SELECT $second_table_name.*, " . substr($this->query, 6);

        $tables_names_in_query = array_keys($this->tables_in_query);
        $first_table = $tables_names_in_query[count($tables_names_in_query)-2];
        $this->query = "$this->query $join_type JOIN $second_table_name ON $first_table.$foreign_key = $second_table_name.$primary_key";

        return $this;
    }

    /**
     * Build a raw SQL query
     *
     * @param  string  $query
     * @return Query
     */
    function raw($query) {
        // Method to run raw SQL queries
        $this->query = $query;
        return $this;
    }

    /**
     * Build a SQL query to INSERT data into $table
     *
     * @param  array  $data
     * @return array
     */
    function insert($data) {
        $query = "INSERT INTO $this->table(";
        $that = clone $this;
        $counter = 1;
        foreach ($data as $key => $value) {

            // If column exist in the table in DB
            // Set the data of this instance to return it later
            // Build the query
            $query .= "$key" . (count($data) == $counter ? '' : ', ');

            // add parameters to use it for prepared statement
            $this->types .= "s";
            array_push($this->params, $value);

            // Keep track of columns of incoming data
            $counter += 1;
        }

        // If model has created_at/updated_at property, and is not set in the data, set it automatically
        $created_at_column = constant($this->tables_in_query["$this->table"] . "::CREATED_AT");
        $updated_at_column = constant($this->tables_in_query["$this->table"] . "::UPDATED_AT");
        if(is_string($created_at_column) && array_search($created_at_column, $data) === FALSE) {
            $query.= " , $created_at_column";
            array_push($data, ["$created_at_column" => ""]);
            $created_at_value = date("Y-m-d H:i:s");
            $this->types .= 's';
            array_push($this->params, $created_at_value);
        }
        if(is_string($updated_at_column) && array_search($updated_at_column, $data) === FALSE) {
            $query .= " , $updated_at_column = ? ";
            array_push($data, ["$updated_at_column" => ""]);
            $this->types .= 's';
            array_push($this->params, $created_at_value);
        }

        // close query
        $query .= ')';


        // add query values
        $clause = implode(',', array_fill(0, count($data), '?'));  // creates a string containing ?,?,? 
        $query .= " VALUES($clause) ";

        // execute query
        $this->query = $query;
        $affected_rows = $this->executeStmt();

        // if there is an auto-increment id, set it to the instance
        if(isset($this->conn->insert_id)) {
            $data['auto_increment_id'] = $this->conn->insert_id;
        }

        return $affected_rows > 0 ? $data : [];
    }

    /**
     * Remove `SELECT X FROM $table` from the query
     *
     * @return string
     */
    private function removeSelectionPart() {
        $start_index = stripos($this->query, "FROM $this->table") + strlen("FROM $this->table") + 1;
        $rest_of_the_query = substr($this->query, $start_index);
        return $rest_of_the_query;
    }
    
    /**
     * Build a SQL query to UPDATE a row
     *
     * @param  array  $data
     * @return bool
     */
    public function update($data) {
        $query = "UPDATE $this->table SET ";
        $counter = 1;
        
        // Loop over data
        foreach ($data as $key => $value) {
            // Build the query
            $query .= "$key = ?" . (count($data) == $counter ? '' : ', ');

            // add parameters to use it for prepared statement
            $this->types .= "s";
            array_push($this->params, $value);

            $counter += 1;
        }

        // If model has updated_at property, and is not set in the data, set it automatically
        $updated_at_column = constant($this->tables_in_query["$this->table"] . "::UPDATED_AT");
        if(is_string($updated_at_column) && array_search($updated_at_column, $data) === FALSE) {
            $query .= " , $updated_at_column = ?";
            $updated_at_value = date("Y-m-d H:i:s");
            array_push($data, ["$updated_at_column" => $updated_at_value]);
            $this->types .= 's';
            array_push($this->params, $updated_at_value);
        }

        // if parameters are set correctly, proceed building the query
        if(count($this->params) > 0) {
            $this->query = $this->removeSelectionPart();
            
            // if there is no where\having clause
            if(!$this->queryHasCondition())
                // DON'T apply update to any record
                return false;

            // else, there is a where clause
            else
                // add the clause after the update
                $query = "$query $this->query";
            array_push($this->params, array_shift($this->params));

            // set query to this instance & execute
            $this->query = $query;
            $affected_rows = $this->executeStmt();
            return $affected_rows > 0;
        }
        // else, parameters aren't set correctly
        else {
            throw new Exception("Bad query: $this->query", 1);
        }
        return false;
    }

    /**
     * Delete row(s) from a table
     *
     * @return bool
     */
    public function delete() {
        // Check if there is a conditon in the query
        // to determine which records to delete
        if($this->queryHasCondition()) {
            $this->query = "DELETE FROM $this->table $this->query";
            $affected_rows = $this->executeStmt();
            return $affected_rows > 0;
        }
        return false;
    }

}


class_alias('\Core\QueryBuilder', 'Query');

?>