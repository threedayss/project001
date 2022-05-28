<?php
    class Transaction
    {
        protected $conn;
        protected $message;
        protected $bill;
        
        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            $this->conn = $conn;
            $this->message = array();
        }

        public function processPayment($email, $cardNo, $expiry, $order_id, $table_num, $coupon_id)
        {
            date_default_timezone_set("Asia/Singapore");
            $total = 0;

            $SQLSelectC = "SELECT * FROM cart_table WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qSelectC = $this->conn->query($SQLSelectC);

            $date = date("Y/m/d");

            if(($res = $qSelectC->num_rows) > 0)
            {
                while(($RowC=$qSelectC->fetch_assoc()) != NULL)
                {
                    $food_id = $RowC["food_id"];
                    $quantity = $RowC["quantity"];
    
                    $SQLSelectF = "SELECT * FROM menu_table WHERE food_id = '$food_id'";
                    $qSelectF = $this->conn->query($SQLSelectF);
    
                    $RowF = $qSelectF->fetch_assoc();
    
                    $price = $RowF["price_per_unit"];
                    $total = $total + ($quantity * $price);
    
                    //To insert all the orders info into the transaction_history table
                    $SQLInsertT = "INSERT INTO transaction_history(transaction_date, order_id, table_num, food_id, quantity)" . 
                                  "VALUES ('$date', '$order_id', '$table_num', '$food_id', '$quantity')";
                    $qInsertT = $this->conn->query($SQLInsertT);
    
                    if($qInsertT == FALSE)
                    {
                        $message["result"] = FALSE;
                        $message["errorMsg"] = "Cannot insert into transactions";
    
                        $this->message = $message;
                        return $message;
                    }
                }
            }
            else
            {
                $message["result"] = FALSE;
                $message["errorMsg"] = "There is no item in the cart";
    
                $this->message = $message;
                return $message;
            }
            
            //To check if the user has inputted any coupon code or not
            if(trim($coupon_id) != "")
            {
                //To check if the coupon exist or not
                $SQLCheckC = "SELECT * FROM coupon_table WHERE coupon_id = '$coupon_id'";
                $qCheckC = $this->conn->query($SQLCheckC);

                if(($res = $qCheckC->num_rows) > 0)
                {
                    $RowCo = $qCheckC->fetch_assoc();

                    //To check whether the stock of the coupon is enough
                    $stock = $RowCo["stock"];
                    $stock -= 1;

                    if($stock < 0)
                    {
                        $message["result"] = FALSE;
                        $message["errorMsg"] = "There is not enough coupon";

                        $this->message = $message;
                        return $message;
                    }
                    else
                    {
                        $SQLUpdate = "UPDATE coupon_table SET stock = '$stock' WHERE coupon_id = '$coupon_id'";
                        $qUpdate = $this->conn->query($SQLUpdate);

                        if($qUpdate == FALSE)
                        {
                            $message["result"] = FALSE;
                            $message["errorMsg"] = "Cannot update the stock of the coupon";

                            $this->message = $message;
                            return $message;
                        }
                    }

                    //To check whether the coupon is valid or not
                    $startDate = strtotime($RowCo["start_date"]);
                    $endDate = strtotime($RowCo["end_date"]);
                    $datee = strtotime($date);

                    if($datee < $startDate)
                    {
                        $message["result"] = FALSE;
                        $message["errorMsg"] = "Coupon code cannot be used yet";

                        $this->message = $message;
                        return $message;
                    }
                    elseif($datee > $endDate)
                    {
                        $message["result"] = FALSE;
                        $message["errorMsg"] = "The coupon code has expired";

                        $this->message = $message;

                        return $message;
                    }
                    else
                    {
                        $total -= $RowCo["value"];
                        $qCheckC = TRUE;
                    }  
                }   
                else
                {
                    $message["result"] = FALSE;
                    $message["errorMsg"] = "Coupon code does not exist";

                    $this->message = $message;
                    
                    return $message;
                }
            }
            else
                $qCheckC = TRUE;
                    
            $hour = date("H:i");

            //To insert the payment info of the particular order into the payment_info table
            $SQLInsertP = "INSERT INTO payment_info(transaction_date, transaction_hour, order_id, table_num, email, cardNum, expiry, total_amount)" .
                        "VALUES ('$date', '$hour', '$order_id', '$table_num', '$email', '$cardNo', '$expiry', '$total')";
            $qInsertP = $this->conn->query($SQLInsertP);

            if($qInsertP == FALSE)
            {
                $message["result"] = FALSE;
                $message["errorMsg"] = "Cannot insert payment info";

                $this->message = $message;
                
                return $message;
            }

            //To delete the order info from cart
            $SQLDelete = "DELETE FROM cart_table WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qDelete = $this->conn->query($SQLDelete);

            if($qDelete == FALSE)
            {
                $message["result"] = FALSE;
                $message["errorMsg"] = "Cannot delete the cart";

                $this->message = $message;
                
                return $message;
            }

            if($qInsertT == TRUE && $qCheckC == TRUE && $qInsertP == TRUE)
            {
                $message["result"] = TRUE;

                $this->message = $message;
            }

            return $message;    
        }

        public function getBill($order_id, $table_num)
        {
            $i = 0;

            $SQLSelect = "SELECT * FROM transaction_history WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qSelect = $this->conn->query($SQLSelect);

            $SQLPayment = "SELECT * FROM payment_info WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qPayment = $this->conn->query($SQLPayment);

            if(($resT = $qSelect->num_rows) > 0 && ($resP = $qPayment->num_rows) > 0)
            {
                $RowP = $qPayment->fetch_assoc();

                while(($RowT = $qSelect->fetch_assoc()) != NULL)
                {
                    $idF = $RowT["food_id"];

                    $SQLGet = "SELECT * FROM menu_table WHERE food_id = '$idF'";
                    $qGet = $this->conn->query($SQLGet);

                    $RowM = $qGet->fetch_assoc();

                    $bill[0]["result"] = TRUE;
                    $bill[0]["total"] = $RowP["total_amount"];
                    $bill[0]["date"] = $RowP["transaction_date"];
                    $bill[$i]["id"] = $idF;
                    $bill[$i]["name"] = $RowM["food_name"];
                    $bill[$i]["description"] = $RowM["description"];
                    $bill[$i]["picture"] = $RowM["images_URL"];
                    $bill[$i]["price"] = $RowM["price_per_unit"];
                    $bill[$i]["quantity"] = $RowT["quantity"]; 
                    
                    $i++;
                }
            }
            else
            {
                $bill[0]["result"] = FALSE;
                $bill[0]["errorMsg"] = "No transaction has been recorded";
            }

            $this->bill = $bill;
            
            return $this->bill;
        }
    }
?>