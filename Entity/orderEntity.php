<?php
    class Order
    {
        protected $conn;
        protected $list;
        protected $info;

        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            $this->conn = $conn;
            $this->list = array();
            $this->info = array();
        }

        public function addToCart($order_id, $table_num, $food_id, $quantity)
        {
            $SQLCheck = "SELECT * FROM cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qCheck = $this->conn->query($SQLCheck);

            if(($res = $qCheck->num_rows) == 0)
            {
                $SQLInsert = "INSERT INTO cart_table(order_id, table_num, food_id, quantity)" . 
                             "VALUES ('$order_id', '$table_num', '$food_id', $quantity)";
                $qInsert = $this->conn->query($SQLInsert);

                if($qInsert === TRUE)
                    return TRUE;
                else
                    return FALSE;
            }
            else
            {
                $Row = $qCheck->fetch_assoc();
                $quan = $Row["quantity"] + $quantity;

                $SQLUpdate = "UPDATE cart_table SET quantity = $quan WHERE food_id = '$food_id'";
                $qUpdate = $this->conn->query($SQLUpdate);

                if($qUpdate === TRUE)
                    return TRUE;
                else
                    return FALSE;
            }

        }

        public function submitOrder($order_id, $table_num)
        {
            $error = TRUE;

            $SQLSelectO = "SELECT * FROM cart_table WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qSelectO = $this->conn->query($SQLSelectO);

            if(($res = $qSelectO->num_rows) > 0)
            {
                while(($Row = $qSelectO->fetch_assoc()) != NULL && $error == TRUE)
                {
                    $idF = $Row["food_id"];
                    $idO = $Row["order_id"];
                    $quantityC = $Row["quantity"];

                    //To update the stock inside the menu table
                    $SQLSelectM = "SELECT stock FROM menu_table WHERE food_id='$idF'";
                    $qSelectM = $this->conn->query($SQLSelectM);

                    $RowM = $qSelectM->fetch_assoc();

                    $quantityM = $RowM["stock"];
                    $newQuantity = $quantityM - $quantityC;

                    if($newQuantity < 0)
                        $error = FALSE;
                    else
                    {
                        $SQLUpdate = "UPDATE menu_table SET stock = '$newQuantity' WHERE food_id='$idF'";
                        $qUpdate = $this->conn->query($SQLUpdate);

                        if($qUpdate == FALSE)
                            $error = FALSE;
                    }
                    
                    //To insert the foods from cart to orders table
                    $SQLInsert = "INSERT INTO orders_table(order_id, table_num, food_id, quantity, status)" . 
                                 "VALUES('$idO', '$table_num', '$idF', '$quantityC', 'In the Kitchen')";
                    $qInsert = $this->conn->query($SQLInsert);

                    if($qInsert == FALSE)
                        $error = FALSE;
                }

                if($error == FALSE)
                    return FALSE;
                else
                    return TRUE;
            }
            else
                return FALSE;
        }

        public function getOrderedItem($order_id, $table_num, $food_id)
        {
            $i = 0;

            $SQLGetO = "SELECT * FROM orders_table WHERE order_id = '$order_id' and table_num = '$table_num'";
            $qGetO = $this->conn->query($SQLGetO);
            
            while(($RowO = $qGetO->fetch_assoc()) != NULL)
            {
                $idF = $RowO["food_id"];

                $SQLGetF = "SELECT * FROM menu_table WHERE food_id = '$food_id'";
                $qGetF = $this->conn->query($SQLGetF);

                $SQLGetD = "SELECT transaction_date FROM transaction_history WHERE order_id = '$order_id'";
                $qGetD = $this->conn->query($qGetD);

                $RowD = $qGetD->fetch_assoc();
                $RowF = $qGetF->fetch_assoc();

                $list[$i]["name"] = $RowF["food_name"];
                $list[$i]["order_id"] = $order_id;
                $list[$i]["food_id"] = $idF;
                $list[$i]["price"] = $RowF["price_per_unit"];
                $list[$i]["quantity"] = $RowO["quantity"];
                $list[$i]["table_num"] = $table_num;
                $list[$i]["transactions_date"] = $RowD["transaction_date"];

                $i++;
            }

            $this->list = $list;

            return $list;
        }

        public function getCartList($order_id)
        {
            $i = 0;

            $SQLGet = "SELECT * FROM cart_table WHERE order_id='$order_id'";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                while(($RowC=$qGet->fetch_assoc()) != NULL)
                {
                    $food_id = $RowC["food_id"];

                    $SQLSelect = "SELECT * FROM menu_table WHERE food_id = '$food_id'"; 
                    $qSelect = $this->conn->query($SQLSelect);

                    $RowM = $qSelect->fetch_assoc();

                    $list[0]["result"] = TRUE;
                    $list[$i]["order_id"] = $order_id;
                    $list[$i]["table_num"] = $RowC["table_num"];
                    $list[$i]["food_id"] = $food_id;
                    $list[$i]["food_name"] = $RowM["food_name"];
                    $list[$i]["price"] = $RowM["price_per_unit"];
                    $list[$i]["quantity"] = $RowC["quantity"];
                    $list[$i]["picture"] = $RowM["images_URL"];
                    $list[$i]["description"] = $RowM["description"];

                    $i++;
                }
            }
            else
            {
                $list[0]["result"] = FALSE;
                $list[0]["errorMsg"] = "Do not have item in the cart";
            }

            $this->list = $list;

            return $this->list;
        }

        public function minusQuantityCart($order_id, $food_id)
        {
            $SQLSelect = "SELECT quantity FROM cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res = $qSelect->num_rows) > 0)
            {
                $Row = $qSelect->fetch_assoc();

                $quantity = $Row["quantity"];
                $quantity -= 1;

                if($quantity < 0 || $quantity == 0)
                {
                    //To delete the order from cart if the quantity is 0
                    $SQLDelete = "DELETE FROM cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
                    $qDelete = $this->conn->query($SQLDelete);
                    
                    if($qDelete == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot be deleted";
                    }
                    else
                        $info["result"] = TRUE;
                }
                else
                {   
                    //To update the quantity of the order if the quantity is not 0
                    $SQLUpdate = "UPDATE cart_table SET quantity = '$quantity' WHERE order_id = '$order_id' AND food_id = '$food_id'";
                    $qUpdate = $this->conn->query($SQLUpdate);
    
                    if($qUpdate == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot minus quantity";
                    }
                    else
                        $info["result"] = TRUE;
                }   
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Food is not in the cart";
            }

            $this->info = $info;

            return $this->info;
        }

        public function addQuantityCart($order_id, $food_id)
        {
            $SQLSelect = "SELECT quantity from cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res=$qSelect->num_rows) > 0)
            {
                $Row = $qSelect->fetch_assoc();

                $quantity = $Row["quantity"];
                $quantity += 1;

                $SQLUpdate = "UPDATE cart_table SET quantity = '$quantity' WHERE order_id = '$order_id' AND food_id = '$food_id'";
                $qUpdate = $this->conn->query($SQLUpdate);

                if($qUpdate == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot add quantity";
                }
                else
                    $info["result"] = TRUE;
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Food is not in the cart";
            }

            $this->info = $info;

            return $this->info;
        }

        public function removeItemCart($order_id, $food_id)
        {
            $SQLSelect = "SELECT * FROM cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res = $qSelect->num_rows) > 0)
            {
                $SQLDelete = "DELETE FROM cart_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
                $qDelete = $this->conn->query($SQLDelete);

                if($qDelete == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot delete item";
                }
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Item is not in the cart";
            }

            $this->info = $info;

            return $this->info;
        }

        public function clearCart($order_id)
        {
            $SQLSelect = "SELECT * FROM cart_table WHERE order_id = '$order_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res=$qSelect->num_rows) > 0)
            {
                $SQLDelete = "DELETE FROM cart_table WHERE order_id = '$order_id'";
                $qDelete = $this->conn->query($SQLDelete);

                if($qDelete == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot clear cart";
                }
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "No item in cart";
            }

            $this->info= $info;

            return $this->info;
        }

        public function getOrdersInfo()
        {
            $i = 0;

            $SQLGet = "SELECT * FROM orders_table";
            $qGet = $this->conn->query($SQLGet);

            if(($res=$qGet->num_rows) > 0)
            {
                while(($RowO=$qGet->fetch_assoc()) != NULL)
                {
                    $idF = $RowO["food_id"];

                    $SQLSelect = "SELECT * FROM menu_table WHERE food_id = '$idF'";
                    $qSelect = $this->conn->query($SQLSelect);

                    $RowM = $qSelect->fetch_assoc();

                    $list[0]["result"] = TRUE;
                    $list[$i]["name"] = $RowM["food_name"];
                    $list[$i]["order_id"] = $RowO["order_id"];
                    $list[$i]["food_id"] = $idF;
                    $list[$i]["description"] = $RowM["description"];
                    $list[$i]["picture"] = $RowM["images_URL"];
                    $list[$i]["price"] = $RowM["price_per_unit"];
                    $list[$i]["quantity"] = $RowO["quantity"];
                    $list[$i]["table_num"] = $RowO["table_num"];
                    $list[$i]["status"] = $RowO["status"];

                    $i++;
                }
            }
            else
            {
                $list[0]["result"] = FALSE;
                $list[0]["errorMsg"] = "No orders found";
            }

            $this->list = $list;

            return $this->list;
        }

        public function updateProgress($order_id, $food_id)
        {
            $notServed = 0;

            $SQLSelect = "SELECT * FROM orders_table WHERE order_id = '$order_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res = $qSelect->num_rows) > 0)
            {
                while(($Row = $qSelect->fetch_assoc()) != NULL)
                {
                    if($Row["status"] == "In the Kitchen")
                        $notServed += 1;
                }   

                if($notServed > 1)
                {
                    //To update the status of the order
                    $SQLUpdate = "UPDATE orders_table SET status = 'Served' WHERE order_id='$order_id' AND food_id = '$food_id'";
                    $qUpdate = $this->conn->query($SQLUpdate);
    
                    if($qUpdate == TRUE)
                    {
                        $info["result"] = TRUE;

                        $this->info = $info;
                    }
                    else
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot Update";

                        $this->info = $info;
                    }
                }
                else
                {
                    //To delete the info about the order if all the foods has been served
                    $SQLDelete = "DELETE FROM orders_table WHERE order_id = '$order_id'";
                    $qDelete = $this->conn->query($SQLDelete);

                    if($qDelete == TRUE)
                    {
                        $info["result"] = TRUE;

                        $this->info = $info;
                    }    
                    else
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot delete";

                        $this->info = $info;
                    }
                }
                
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "The order does not exist";

                $this->info = $info;
            }

            return $this->info;
        }

        public function getOrderInfo($order_id)
        {
            $i = 0;

            $SQLGet = "SELECT DISTINCT order_id FROM transaction_history";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                while(($RowG = $qGet->fetch_assoc()) != NULL)
                {
                    $counter = 0;
                    $idQuan = "";

                    $idO = $RowG["order_id"];
                    
                    if(stristr($idO, $order_id))
                    {
                        $SQLSelectT = "SELECT * FROM transaction_history WHERE order_id = '$idO'";
                        $qSelectT = $this->conn->query($SQLSelectT);

                        while(($RowT = $qSelectT->fetch_assoc()) != NULL)
                        {
                            $idF = $RowT["food_id"];
                            $quantity =  $RowT["quantity"];

                            if($counter == 0)
                            {
                                $idQuan = "$idF: $quantity";
                                $counter++;
                            }
                            else
                            {
                                $idQuan .= ", $idF: $quantity";
                                $counter++;
                            }
                        }

                        $SQLSelectP = "SELECT * FROM payment_info WHERE order_id = '$idO'";
                        $qSelectP = $this->conn->query($SQLSelectP);

                        $RowP = $qSelectP->fetch_assoc();

                        // To organize the array
                        $list[0]["result"] = TRUE;
                        $list[$i]["date"] = $RowP["transaction_date"];
                        $list[$i]["total"] = $RowP["total_amount"];
                        $list[$i]["order_id"] = $idO;
                        $list[$i]["info"] = $idQuan;
                        $list[$i]["table_num"] = $RowP["table_num"];

                        $i++;
                    }
                }

                $this->list = $list;
            }
            else
            {
                $list[0]["result"] = FALSE;
                $list[0]["errorMsg"] = "The order does not exist";

                $this->list = $list;
            }

            return $this->list;
        }

        public function cancelOrder($order_id, $table_num)
        {
            $SQLSelect = "SELECT * FROM orders_table WHERE order_id = '$order_id' AND table_num = '$table_num'";
            $qSelect = $this->conn->query($SQLSelect);

            //To check whether such order exists
            if(($res = $qSelect->num_rows) > 0)
            {
                //To update the stock back
                while(($RowO = $qSelect->fetch_assoc()) != NULL)
                {
                    $quantity = $RowO["quantity"];
                    $food_id = $RowO["food_id"];
                    
                    //To update the stock of the food
                    $SQLGet = "SELECT * FROM menu_table WHERE food_id='$food_id'";
                    $qGet = $this->conn->query($SQLGet);

                    $RowM = $qGet->fetch_assoc();

                    $stock = $RowM["stock"];
                    $newQuantity = $stock + $quantity;

                    $SQLUpdate = "UPDATE menu_table SET stock = '$newQuantity' WHERE food_id = '$food_id'";
                    $qUpdate = $this->conn->query($SQLUpdate);

                    if($qUpdate == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "The stock cannot be updated";

                        $this->info = $info;

                        return $this->info;
                    }
                }  

                //To delete the orders from order table
                $SQLDeleteO = "DELETE FROM orders_table WHERE order_id = '$order_id'";
                $qDeleteO = $this->conn->query($SQLDeleteO);

                if($qDeleteO == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "The order cannot be deleted";

                    $this->info = $info;

                    return $this->info;
                }
                
                //To delete the orders info from payment info table
                $SQLDeleteP = "DELETE FROM payment_info WHERE order_id = '$order_id' AND table_num = '$table_num'";
                $qDeleteP = $this->conn->query($SQLDeleteP);

                if($qDeleteP == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "The payment info cannot be deleted";

                    $this->info = $info;

                    return $this->info;
                }

                //To delete the orders info from transaction history table
                $SQLDeleteT = "DELETE FROM transaction_history WHERE order_id = '$order_id' AND table_num = '$table_num'";
                $qDeleteT = $this->conn->query($SQLDeleteT);

                if($qDeleteT == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "The transaction history cannot be deleted";

                    $this->info = $info;

                    return $this->info;
                }

                if($qDeleteT == TRUE && $qDeleteP == TRUE && $qDeleteO == TRUE && $qUpdate == TRUE)
                {
                    $info["result"] = TRUE;

                    $this->info = $info;

                    return $this->info;
                }
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "The order does not exist";

                $this->info = $info;

                return $this->info;
            }
        }

        public function minusQuantityOrder($order_id, $food_id)
        {
            $SQLSelectO = "SELECT * FROM orders_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelectO = $this->conn->query($SQLSelectO);

            if(($res = $qSelectO->num_rows) > 0)
            {
                $Row = $qSelectO->fetch_assoc();

                //To check if the stock is still available or not
                $SQLSelectS = "SELECT stock, price_per_unit FROM menu_table WHERE food_id='$food_id'";
                $qSelectS = $this->conn->query($SQLSelectS);

                $RowS = $qSelectS->fetch_assoc();

                $stock = $RowS["stock"];
                $newStock = $stock + 1;

                //To update the stock
                $SQLUpdateS = "UPDATE menu_table SET stock = '$newStock' WHERE food_id = '$food_id'";
                $qUpdateS = $this->conn->query($SQLUpdateS);

                if($qUpdateS == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Stock cannot be updated";
                }
                else
                {
                    $info["result"] = TRUE;

                    //To update the quantity of the orders
                    $quantity = $Row["quantity"];
                    $quantity -= 1;
    
                    $SQLUpdateO = "UPDATE orders_table SET quantity = '$quantity' WHERE order_id = '$order_id' AND food_id = '$food_id'";
                    $qUpdateO = $this->conn->query($SQLUpdateO);
        
                    if($qUpdateO == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot minus quantity in orders";
                    }
                    else
                        $info["result"] = TRUE;
    
                    //To update transaction history
                    $SQLUpdateT = "UPDATE transaction_history set quantity = '$quantity' WHERE order_id='$order_id' AND food_id = '$food_id'";
                    $qUpdateT = $this->conn->query($SQLUpdateT);
    
                    if($qUpdateT == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot minus quantity in transaction history";
                    }
                    else
                        $info["result"] = TRUE;
    
                    //To update the payment info
                    $price = $RowS["price_per_unit"];
    
                    $SQLGetP = "SELECT * FROM payment_info WHERE order_id='$order_id'";
                    $qGetP = $this->conn->query($SQLGetP);
    
                    $RowP = $qGetP->fetch_assoc();
    
                    $subtotal = $RowP["total_amount"];
                    $newTotal = $subtotal - $price;
    
                    $SQLUpdateP = "UPDATE payment_info SET total_amount = '$newTotal' WHERE order_id = '$order_id'";
                    $qUpdateP = $this->conn->query($SQLUpdateP);
    
                    if($qUpdateP == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot update price";
                    }
                    else
                        $info["result"] = TRUE;
                }

                $this->info = $info;
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Food is not in the orders";

                $this->info = $info;
            }

            return $this->info;
        }

        public function addQuantityOrder($order_id, $food_id)
        {
            $SQLSelect = "SELECT quantity from orders_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res=$qSelect->num_rows) > 0)
            {
                $Row = $qSelect->fetch_assoc();

                //To check if the stock is still available or not
                $SQLSelectS = "SELECT stock, price_per_unit FROM menu_table WHERE food_id='$food_id'";
                $qSelectS = $this->conn->query($SQLSelectS);

                $RowS = $qSelectS->fetch_assoc();

                $stock = $RowS["stock"];
                $newStock = $stock - 1;

                //To check if there is enough stock
                if($newStock < 0)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Does not have enough stock";
                }
                else
                {
                    //To update the stock
                    $SQLUpdateS = "UPDATE menu_table SET stock = '$newStock' WHERE food_id = '$food_id'";
                    $qUpdateS = $this->conn->query($SQLUpdateS);

                    if($qUpdateS == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Stock cannot be updated";
                    }
                    else
                        $info["result"] = TRUE;

                    //To update the quantity of the orders
                    $quantity = $Row["quantity"];
                    $quantity += 1;

                    $SQLUpdateO = "UPDATE orders_table SET quantity = '$quantity' WHERE order_id = '$order_id' AND food_id = '$food_id'";
                    $qUpdateO = $this->conn->query($SQLUpdateO);
    
                    if($qUpdateO == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot add quantity in orders";
                    }
                    else
                        $info["result"] = TRUE;
                    
                    //To update transaction history
                    $SQLUpdateT = "UPDATE transaction_history SET quantity = '$quantity' WHERE order_id = '$order_id' AND food_id = '$food_id'";
                    $qUpdateT = $this->conn->query($SQLUpdateT);

                    if($qUpdateT == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot add quantity in transactions";
                    }
                    else
                        $info["result"] = TRUE;
                    
                    //To update payment info
                    $price = $RowS["price_per_unit"];

                    $SQLGetP = "SELECT total_amount FROM payment_info WHERE order_id = '$order_id'";
                    $qGetP = $this->conn->query($SQLGetP);

                    $RowP = $qGetP->fetch_assoc();

                    $subtotal = $RowP["total_amount"];
                    $newTotal = $subtotal + $price;

                    $SQLUpdateP = "UPDATE payment_info SET total_amount = '$newTotal' WHERE order_id = '$order_id'";
                    $qUpdateP = $this->conn->query($SQLUpdateP);
                    
                    if($qUpdateP == FALSE)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Cannot update price";
                    }
                    else
                        $info["result"] = TRUE;
                }

                $this->info = $info;
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Food is not in the orders";

                $this->info = $info;
            }

            return $this->info;
        }

        public function removeItemOrder($order_id, $food_id)
        {
            $SQLSelect = "SELECT * FROM orders_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
            $qSelect = $this->conn->query($SQLSelect);

            if(($res = $qSelect->num_rows) > 0)
            {
                $RowO = $qSelect->fetch_assoc();

                //To update the stock
                $SQLGetM = "SELECT * FROM menu_table WHERE food_id = '$food_id'";
                $qGetM = $this->conn->query($SQLGetM);

                $RowM = $qGetM->fetch_assoc();

                $stock = $RowM["stock"];
                $quantity = $RowO["quantity"];

                $newStock = $stock + $quantity;

                $SQLUpdate = "UPDATE menu_table SET stock = '$newStock' WHERE food_id = '$food_id'";
                $qUpdate = $this->conn->query($SQLUpdate);

                if($qUpdate == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot update stock";
                }
                else
                    $info["result"] = TRUE;

                //To update the price in payment_info
                $price = $RowM["price_per_unit"];
                $tempTotal = (float)$price * (int)$quantity;

                $SQLGetP = "SELECT total_amount FROM payment_info WHERE order_id = '$order_id'";
                $qGetP = $this->conn->query($SQLGetP);

                $RowP = $qGetP->fetch_assoc();

                $subtotal = $RowP["total_amount"];
                $newTotal = $subtotal - $tempTotal;

                $SQLUpdateP = "UPDATE payment_info SET total_amount = '$newTotal' WHERE order_id = '$order_id'";
                $qUpdateP = $this->conn->query($SQLUpdateP);

                if($qUpdateP == FALSE)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot update price";
                }
                else
                    $info["result"] = TRUE;

                //To delete the info from order table
                $SQLDeleteO = "DELETE FROM orders_table WHERE order_id = '$order_id' AND food_id = '$food_id'";
                $qDeleteO = $this->conn->query($SQLDeleteO);

                if($qDeleteO == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot delete item from order";
                }

                //To delete the info from transaction history
                $SQLDeleteT = "DELETE FROM transaction_history WHERE order_id = '$order_id' AND food_id = '$food_id'";
                $qDeleteT = $this->conn->query($SQLDeleteT);

                if($qDeleteT == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot delete item from transaction";
                }  
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Item is not in the orders";
            }

            $this->info = $info;

            return $this->info;
        }

        public function createOrder($table_num, $order_id, $staff_id)
        {
            $newID = 0;
            $cart = TRUE;
            $staff = TRUE;
            $order = TRUE;

            //To check whether the table number inputted is currently active or not
            $SQLCheckC = "SELECT * FROM cart_table WHERE table_num = '$table_num'";
            $qCheckC = $this->conn->query($SQLCheckC );

            if(($resC = $qCheckC->num_rows) > 0)
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Table number is currently used";

                $cart = FALSE;

                $this->info = $info;
            }

            //To check the validity of the staff id inserted
            $SQLCheckS = "SELECT * FROM user_account WHERE id = '$staff_id' AND profile = 'Staff'";
            $qCheckS = $this->conn->query($SQLCheckS);

            if(($resS = $qCheckS->num_rows) > 0)
            {
                $Row = $qCheckS->fetch_assoc();

                if($Row["status"] == "Suspended")
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "User is currently suspended";

                    $staff = FALSE;

                    $this->info = $info;
                }

            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Staff ID does not exist";

                $staff = FALSE;

                $this->info = $info;
            }

            //To check order id
            if($order_id != "")
            {
                //To check whether the order id has been used previously or not
                $SQLCheckO = "SELECT * FROM payment_info WHERE order_id = '$order_id'";
                $qCheckO = $this->conn->query($SQLCheckO);

                if(($resO = $qCheckO->num_rows) > 0)
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Order ID has been used before";

                    $order = FALSE;

                    $this->info = $info;
                }

                //To check whether the order id is being used for other table or not
                $SQLCheckO2 = "SELECT DISTINCT order_id FROM cart_table";
                $qCheckO2 = $this->conn->query($SQLCheckO2);

                while(($RowO = $qCheckO2->fetch_assoc()) != NULL)
                {
                    if($RowO["order_id"] == $order_id)
                    {
                        $info["result"] = FALSE;
                        $info["errorMsg"] = "Order ID is currently used";

                        $order = FALSE;

                        $this->info = $info;
                    }
                }

                if($order == TRUE)
                    $newID = NULL;
            }
            else
            {
                //To generate a unique order id
                $maxP = 0;
                $maxC = 0;

                $SQLSelectP = "SELECT order_id FROM payment_info";
                $qSelectP = $this->conn->query($SQLSelectP);

                while(($RowSP = $qSelectP->fetch_assoc()) != NULL)
                {
                    if($RowSP["order_id"] > $maxP)
                        $maxP = $RowSP["order_id"];
                }

                $SQLSelectC = "SELECT DISTINCT order_id FROM cart_table";
                $qSelectC = $this->conn->query($SQLSelectC);

                while(($RowSC = $qSelectC->fetch_assoc()) != NULL)
                {
                    if($RowSC["order_id"] > $maxC)
                        $maxC = $RowSC["order_id"];
                }

                if($maxC > $maxP)
                    $newID = $maxC + 1;
                else
                    $newID = $maxP + 1;
                
                $info["id"] = $newID;
            }

            if($cart == TRUE && $staff == TRUE && $order == TRUE)
            {
                $info["result"] = TRUE;
                $info["id"] = $newID;

                $this->info = $info;
            }

            return $this->info;
        }

        public function getHistoryOrder()
        {
            $i = 0;

            $SQLGet = "SELECT DISTINCT order_id FROM transaction_history";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                
                while(($RowG = $qGet->fetch_assoc()) != NULL)
                {
                    $counter = 0;
                    $idQuan = "";

                    $order_id = $RowG["order_id"];

                    $SQLSelectT = "SELECT * FROM transaction_history WHERE order_id = '$order_id'";
                    $qSelectT = $this->conn->query($SQLSelectT);

                    while(($RowT = $qSelectT->fetch_assoc()) != NULL)
                    {
                        $idF = $RowT["food_id"];
                        $quantity =  $RowT["quantity"];

                        if($counter == 0)
                        {
                            $idQuan = "$idF: $quantity";
                            $counter++;
                        }
                        else
                        {
                            $idQuan .= ", $idF: $quantity";
                            $counter++;
                        }
                    }

                    $SQLSelectP = "SELECT * FROM payment_info WHERE order_id = '$order_id'";
                    $qSelectP = $this->conn->query($SQLSelectP);

                    $RowP = $qSelectP->fetch_assoc();

                    // To organize the array
                    $list[0]["result"] = TRUE;
                    $list[$i]["date"] = $RowP["transaction_date"];
                    $list[$i]["total"] = $RowP["total_amount"];
                    $list[$i]["order_id"] = $order_id;
                    $list[$i]["info"] = $idQuan;
                    $list[$i]["table_num"] = $RowP["table_num"];

                    $i++;
                }

                $this->list = $list;
            }
            else
            {
                $list[0]["result"] = FALSE;
                $list[0]["errorMsg"] = "There has not been any transactions";

                $this->list = $list;
            }

            return $this->list;
        }
    }
?>