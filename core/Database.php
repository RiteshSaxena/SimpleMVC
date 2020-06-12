<?php
namespace Core;

use PDO;

class Database {
    private $conn;

    function __construct() {
        $dsn = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
        if (defined("DB_PORT")) {
            $dsn .= ";port=" . DB_PORT;
        }
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->conn = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        } catch (\PDOException $e) {
            if (DEV_MODE) {
                die("Error:" . $e->getMessage());
            } else {
                die("Error connecting to db");
            }
        }
    }

    function __destruct() {
        $this->conn = null;
    }

    public function query($query, $params = []) {
        if (count($params) > 0) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $this->conn->query($query);
        }
        $statement = strtolower(explode(" ", $query)[0]);
        if ($statement === "select" || $statement === "show" || $statement === "call" || $statement === "describe") {
            return [$stmt->rowCount(), $stmt->fetchAll()];
        } elseif ($statement === "insert" || $statement === "update" || $statement === "delete") {
            return $stmt->rowCount();
        }
        return true;
    }

    public function rowCount($query, $params = []) {
        if (count($params) > 0) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $this->conn->query($query);
        }
        return $stmt->rowCount();
    }

    public function fetch($query, $params = []) {
        if (count($params) > 0) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $this->conn->query($query);
        }
        return $stmt->fetchAll();
    }
}
