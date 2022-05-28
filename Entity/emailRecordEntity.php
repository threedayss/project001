<?php
    class EmailRecord
    {
        protected $conn;
        protected $result;

        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            $this->conn = $conn;
            $this->result = array();
        }

        public function getRecord()
        {
            $SQLGet = "SELECT * FROM payment_info group by transaction_date desc, order_id, email";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                $i = 0;

                while(($Row = $qGet->fetch_assoc()) !== NULL)
                {
                    $displayDate = date("d/m/Y", strtotime($Row["transaction_date"]));

                    $result[$i]["email"] = $Row["email"];
                    $result[$i]["order_id"] = $Row["order_id"];
                    $result[$i]["transaction_date"] = $displayDate;

                    $i++;
                }
            }
            else
                $result["message"] = "No email recorded";

            $this->result = $result;

            return $this->result;
        }
    }
?>