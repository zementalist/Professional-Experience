<?php

namespace Core;
use Core\QueryBuilder as Query;

trait Fluent
{
    /**
     * Model's required relationships
     *
     * @var array
     */
    protected static $eager_load = [];
    
    /**
     * Grab all rows from a table
     *
     * @param  array  $columns
     * @return Query
     */
    public static function all($columns = ['*']) {
        // Method to retreive all rows of a table
        return (new Query(static::class))->select($columns)->get();
    }

    /**
     * Find a specific row by ID
     *
     * @param  string  $value
     * @return mixed
     */
    public static function find($value) {
        $class = static::class;
        $instance = new $class;
        $primaryKey = $instance->getPrimaryKey();
        $instance = self::where($primaryKey, $value)->get();
        return $instance ? $instance[0] : [];
    }

    /**
     * Select columns from table
     *
     * @param  array  $columns
     * @return Query
     */
    public static function select($columns=['*']) {
        return (new Query(static::class))->select($columns);
    }

    /**
     * Add a WHERE clause to SQL query
     *
     * @param  string $column
     * @param mixed $value
     * @param string $operator
     * @return Query
     */
    public static function where($column, $value=null, $operator=null) {
        return (new Query(static::class))->where($column, $value, $operator);
    }

    /**
     * Add multiple WHERE clauses to SQL query
     *
     * @param  array  $array
     * @return Query
     */
    public static function multi_where(array $array) {
        return (new Query(static::class))->multi_where($array);
        
    }

    /**
     * Add WHERE IN clause to SQL query
     *
     * @param  string $column
     * @param array $values
     * @return Query
     */
    public static function whereIn($column, array $values) {
        return (new Query(static::class))->whereIn($column, $values);
    }

    /**
     * Add WHERE NOT IN clause to SQL query
     *
     * @param  string $column
     * @param array $values
     * @return Query
     */
    public static function whereNotIn($column, array $values) {
        // Method to select rows using WHERE NOT IN clause
        return (new Query(static::class))->whereNotIn($column, $values);
    }

    /**
     * Add 'WHERE column IS NULL' to SQL query
     *
     * @param  string $column
     * @return Query
     */
    public static function whereNull($column) {
        // Method to select rows using WHERE column IS NULL
        return (new Query(static::class))->whereNull($column);
    }

    /**
     * Add 'WHERE column IS NOT NULL' to SQL query
     *
     * @param  string $column
     * @return Query
     */
    public static function whereNotNull($column) {
        // Method to select rows using WHERE column IS NOT NULL
        return (new Query(static::class))->whereNotNull($column);
    }

    /**
     * Add a WHERE clause to SQL query without prepared statements
     *
     * @param string $query
     * @return Query
     */
    public static function whereRaw($query) {
        return (new Query(static::class))->whereRaw($query);
    }

    /**
     * GROUP table rows BY column
     *
     * @param  string $column
     * @return Query
     */
    public static function groupBy($column) {
        return (new Query(static::class))->select()->groupBy($column);
    }
    
    /**
     * ORDER table rows BY column
     *
     * @param  string $column
     * @param string @order
     * @return Query
     */
    public static function orderBy($column, $order="ASC") {
        return (new Query(static::class))->select()->orderBy($column);
    }

    /**
     * Make a query to SELECT the most recent row in a table
     *
     * @param  string $column
     * @return Query
     */
    public static function latest($column="created_at") {
        return (new Query(static::class))->select()->latest($column);
    }

    /**
     * Make a query to SELECT the most old row in a table
     *
     * @param  string $column
     * @return Query
     */
    public static function oldest($column="created_at") {
        return (new Query(static::class))->select()->oldest($column);
    }

    /**
     * Add a LIMIT to SQL selected rows
     *
     * @param  int $n_rows
     * @return Query
     */
    public static  function take($n_rows) {
        return (new Query(static::class))->select()->take($n_rows);
    }

    /**
     * Add a LIMIT to SQL selected rows
     *
     * @param  int $n_rows
     * @return Query
     */
    public static function limit($n_rows) {
        // Method to LIMIT the number of selected rows
        return self::take($n_rows);
    }

    /**
     * Join tables
     *
     * @param  string $second_table_class
     * @param string $current_table_key
     * @param string $second_table_key
     * @param string $join_type
     * @return Query
     */
    public static function join($second_table_class, $current_table_key, $second_table_key, $join_type="INNER") {
        return (new Query(static::class))->join(...func_get_args());
    }

    /**
     * INSERT data INTO table
     *
     * @param  array $data
     * @return Query
     */
    public static function insert($data) {
        return (new Query(static::class))->insert($data);
    }

    /**
     * Create a raw query
     *
     * @param  string $query
     * @return Query
     */
    public static function raw($query) {
        // Method to run raw SQL queries
        return (new Query(static::class))->raw($query);
    }
}


?>