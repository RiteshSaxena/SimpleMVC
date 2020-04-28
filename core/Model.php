<?php
namespace Core;

class Model {
    protected Database $db;

    function __construct() {
        $this->db = new Database();
    }
}
