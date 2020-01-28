<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $conn;
    private $stmt;

    function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
    }

    function __destruct() {
        $this->conn->close();
    }

    function prepare($query){
        $this->stmt = $this->conn->prepare($query);
    }

    function bind($params){
        call_user_func_array(array($this->stmt, 'bind_param'), $this->refValues($params));
    }

    function execute(){
        $this->stmt->execute();
    }

    function close(){
        $this->stmt->close();
    }

    function get_result(){
        $get_result = $this->stmt->get_result();
        $result = $get_result->fetch_all(MYSQLI_ASSOC);
        $num_rows = $get_result->num_rows;
        if(!$result)
            $result = [];
        return [$num_rows, $result];
    }

    function refValues($arr){
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }

    function error() {
        return $this->conn->error;
    }
}
