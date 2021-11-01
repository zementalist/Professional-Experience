<?php

namespace Core\Database;

class Database {

    /**
     * Host name
     *
     * @var string
     */
    protected static $hostname = "localhost";

    /**
     * Database Username
     *
     * @var string
     */
    protected static $username = "root";

    /**
     * Database Password
     *
     * @var string
     */
    private static $password = "";

    /**
     * Database Name
     *
     * @var string
     */
    protected static $dbname = "fluent";

    /**
     * Database object
     *
     * @var Database
     */
    public static $db;

    /**
     * Database Connection
     *
     * @var mysqli
     */
    private $conn;

    /**
     * Connect to a Database
     *
     * @return mysqli
     * 
     * @throws \Exception
     */
    function connect() {

        $this->conn = new \mysqli(self::$hostname, self::$username, self::$password, self::$dbname);
        if($this->conn->connect_error) 
            throw new \Exception("Couldn't connect to Database", 1);
        return $this->conn;

    }

    /**
     * Construct the Database object with a connection
     * 
     * @param  string $hostname
     * @param string $username
     * @param string $password
     * @param string $dbname
     * @return void
     */
    function __construct($hostname=null, $username=null, $password=null, $dbname=null) {
        self::$hostname = $hostname ?? self::$hostname;
        self::$username = $username ?? self::$username;
        self::$password = $password ?? self::$password;
        self::$dbname = $dbname ?? self::$dbname;
        $this->conn = $this->connect();
    }

    /**
     * Get Database Name
     *
     * @return string
     */
    public static function getDBName() {
        return self::$dbname;
    }

    /**
     * Get Database Connection
     *
     * @return mysqli
     */
    public static function getConnection() {
        if(self::$db == null)
            self::$db = new Database();
        return  self::$db->conn;
    } 

}

?>