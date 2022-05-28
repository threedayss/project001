<?php

class Report {
    protected array $array1= [];
    protected array $array2 = [];
    protected array $array3 = [];
    protected $conn;

    public function __construct() {
        $this->conn = mysqli_connect("localhost", "root", "", "DumbledoreDB");
    }

    public function getArray1() {
        return $this->array1;
    }

    public function getArray2() {
        return $this->array2;
    }

    public function getArray3() {
        return $this->array3;
    }

    public function generateReport($time, $name) {
        $stmt = mysqli_stmt_init($this->conn);
    
        if($name == "Average Spent" && $time == "Hour") {
            $sql = "SELECT HOUR(transaction_hour) as time, AVG(total_amount) as avg FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'].":00";
                $amount = "$".$row['avg'];
                array_push($this->array1, $t);
                array_push($this->array2, $amount);
            }

            mysqli_stmt_close($stmt);
        }

        else if($name == "Average Spent" && $time == "Day") {
            $sql = "SELECT DATE(transaction_date) as time, AVG(total_amount) as avg FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $amount = "$".$row['avg'];
                array_push($this->array1, $t);
                array_push($this->array2, $amount);
            }
            
            mysqli_stmt_close($stmt);
        }

        else if($name == "Average Spent" && $time == "Month") {
            $sql = "SELECT MONTHNAME(transaction_date) as time, AVG(total_amount) as avg FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $amount = "$".$row['avg'];
                array_push($this->array1, $t);
                array_push($this->array2, $amount);
            }

            mysqli_stmt_close($stmt);
        }

        else if($name == "Sales Report" && $time == "Hour") {
            $sql = "SELECT HOUR(p.transaction_hour) as time, o.food_id as id, SUM(o.quantity) as sum 
                    FROM payment_info as p
                    JOIN orders_table as o
                    WHERE p.order_id = o.order_id
                    GROUP BY time, id;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'].":00";
                $id = $row['id'];
                $q = $row['sum'];
                array_push($this->array1, $t);
                array_push($this->array2, $id);
                array_push($this->array3, $q);
            }

            mysqli_stmt_close($stmt);
        }
    
        else if($name == "Sales Report" && $time == "Day") {
            $sql = "SELECT DATE(p.transaction_date) as time, o.food_id as id, SUM(o.quantity) as sum 
                    FROM payment_info as p
                    JOIN orders_table as o
                    WHERE p.order_id = o.order_id
                    GROUP BY time, id;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $id = $row['id'];
                $q = $row['sum'];
                array_push($this->array1, $t);
                array_push($this->array2, $id);
                array_push($this->array3, $q);
            }

            mysqli_stmt_close($stmt);
        }                   
   
        else if($name == "Sales Report" && $time == "Month") {
            $sql = "SELECT DISTINCT MONTHNAME(p.transaction_date) as time, o.food_id as id, SUM(o.quantity) as sum 
                    FROM payment_info as p
                    JOIN orders_table as o
                    WHERE p.order_id = o.order_id
                    GROUP BY time, id;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $id = $row['id'];
                $q = $row['sum'];
                array_push($this->array1, $t);
                array_push($this->array2, $id);
                array_push($this->array3, $q);
            }

            mysqli_stmt_close($stmt);        
        }

        else if($name == "Traffic" && $time == "Hour") {
            $sql = "SELECT HOUR(transaction_hour) as time, COUNT(table_num) as traffic FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'].":00";
                $traffic = $row['traffic'];
                array_push($this->array1, $t);
                array_push($this->array2, $traffic);
            }

            mysqli_stmt_close($stmt);
        }

        else if($name == "Traffic" && $time == "Day") {
            $sql = "SELECT DATE(transaction_date) as time, COUNT(table_num) as traffic FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $traffic = $row['traffic'];
                array_push($this->array1, $t);
                array_push($this->array2, $traffic);

            }

            mysqli_stmt_close($stmt);
        }

        else if($name == "Traffic" && $time == "Month") {
            $sql = "SELECT MONTHNAME(transaction_date) as time, COUNT(table_num) as traffic FROM payment_info GROUP BY time;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $t = $row['time'];
                $traffic = $row['traffic'];
                array_push($this->array1, $t);
                array_push($this->array2, $traffic);
            }

            mysqli_stmt_close($stmt);
        }
    }
}