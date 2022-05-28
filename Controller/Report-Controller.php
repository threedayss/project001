<?php

require '../Entity/Report-Entity.php';

class ReportController {
    public $conn;

    public function __construct() {
        $this->conn = new Report();
    }

    public function getArray1() {
        return $this->conn->getArray1();
    }

    public function getArray2() {
        return $this->conn->getArray2();
    }

    public function getArray3() {
        return $this->conn->getArray3();
    }

    public function generateReport($time, $name) {
        return $this->conn->generateReport($time, $name);
    }
}