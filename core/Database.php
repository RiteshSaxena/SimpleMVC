<?php
namespace Core;

class Database {
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $password = DB_PASSWORD;
    private string $database = DB_NAME;
    private \mysqli $conn;
    private \mysqli_stmt $stmt;

    function __construct() {
        $this->conn = new \mysqli($this->host, $this->user, $this->password, $this->database);
    }

    function __destruct() {
        $this->conn->close();
    }

    private function prepare($query){
        $this->stmt = $this->conn->prepare($query);
    }

    private function bind($params){
        call_user_func_array(array($this->stmt, 'bind_param'), $this->refValues($params));
    }

    private function execute(){
        $this->stmt->execute();
    }

    private function close(){
        $this->stmt->close();
    }

    private function refValues($arr){
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }

    private function fetch_results($mode = 0){
        $get_result = $this->stmt->get_result();
        if ($mode == 0 || $mode == 1) {
            $result = $get_result->fetch_all(MYSQLI_ASSOC);
            if(!$result)
                $result = [];
        }
        if ($mode == 0 || $mode == 2)
            $num_rows = $get_result->num_rows;

        if ($mode == 1) {
            return $result;
        } else if ($mode == 2) {
            return $num_rows;
        } else {
            return [$num_rows, $result];
        }
    }

    private function stmt_error() {
        return $this->stmt->error;
    }

    private function conn_error() {
        return $this->conn->error;
    }

    public function error() {
        if ($this->stmt) {
            return $this->stmt_error();
        } else {
            return $this->conn_error();
        }
    }

    function run($query, $params = []){
        $this->prepare($query);
        if (count($params) > 0) {
            $this->bind($params);
        }
        $this->execute();
        $this->close();
    }

    function num_rows($query, $params = []){
        $this->prepare($query);
        if (count($params) > 0) {
            $this->bind($params);
        }
        $this->execute();
        $num_rows = $this->fetch_results(2);
        $this->close();
        return $num_rows;
    }

    function fetch($query, $params = []){
        $this->prepare($query);
        if (count($params) > 0) {
            $this->bind($params);
        }
        $this->execute();
        $result = $this->fetch_results(1);
        $this->close();
        return $result;
    }

    function query($query, $params = []){
        $this->prepare($query);
        if (count($params) > 0) {
            $this->bind($params);
        }
        $this->execute();
        $result = $this->fetch_results();
        $this->close();
        return $result;
    }
}
