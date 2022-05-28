<?php
    class Menu
    {
        protected $conn;
        protected $menu;
		protected $list;
        protected $info;

        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            $this->conn = $conn;
            $this->menu = array();
			$this->list = array();
            $this->info = array();
        }

        public function getMenuList()
        {
            $i = 0;

            // $SQLGetM = "SELECT * FROM menu_table group by category";
            $SQLGetM = "SELECT * FROM menu_table";
            $qGetM = $this->conn->query($SQLGetM);

            while (($Row = $qGetM->fetch_assoc())!= NULL)
            {
                $menu[$i]["id"] = $Row["food_id"];
                $menu[$i]["name"] = $Row["food_name"];
                $menu[$i]["category"] = $Row["category"];
                $menu[$i]["description"] = $Row["description"];
                $menu[$i]["price"] = $Row["price_per_unit"];
                $menu[$i]["pict"] = $Row["images_URL"];

                $i++;
            }

            $this->menu = $menu;

            return $this->menu;
        }

        public function getMenuInfo($food_id)
        {
            $i = 0;

            $SQLCheck = "SELECT * FROM menu_table";
            $qCheck = $this->conn->query($SQLCheck);
			
            while(($Row=$qCheck->fetch_assoc()) != NULL)
            {
                $id = $Row["food_id"];

                if(stristr($id, $food_id) != FALSE)
                {
                    $info[$i]['id'] = $Row['food_id'];
                    $info[$i]['name'] = $Row['food_name'];
                    $info[$i]['category'] = $Row['category'];
                    $info[$i]['description'] = $Row['description'];
                    $info[$i]['price'] = $Row['price_per_unit'];
                    $info[$i]['stock'] = $Row['stock'];
                    $info[$i]['picture'] = $Row['images_URL'];
    
                    
                    $i++;
                }
            }
			
			if($i == 0)
				return NULL;

            $this->info = $info;
            return $this->info;
        }

        public function getItemsInfo()
        {
            $i = 0;

            $SQLGet = "SELECT * FROM menu_table";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                while(($Row = $qGet->fetch_assoc()) != NULL)
                {
                    $list[$i]["id"] = $Row["food_id"];
                    $list[$i]["name"] = $Row["food_name"];
                    $list[$i]["category"] = $Row["category"];
                    $list[$i]["description"] = $Row["description"];
                    $list[$i]["price"] = $Row["price_per_unit"];
                    $list[$i]["stock"] = $Row["stock"];
                    $list[$i]["picture"] = $Row["images_URL"];

                    $i++;
                }
            }
            else
                $list["message"] = "No item inside the menu";
            
            $this->list = $list;

            return $this->list;
        }
		
		public function createMenu($food_cat, $food_name, $food_desc, $stock, $price_per_unit, $images_URL)
        {
            $SQLCheck = "SELECT * FROM menu_table WHERE food_name = '$food_name'";
            $qCheck = $this->conn->query($SQLCheck);

            if(($res = $qCheck->num_rows) == 0)
            {
                $SQLInsert = "INSERT INTO menu_table(food_name, category, description, price_per_unit, stock, images_URL)" . 
                             "VALUES ('$food_name', '$food_cat', '$food_desc', '$price_per_unit', '$stock', '$images_URL')";
                $qInsert = $this->conn->query($SQLInsert);

                if($qInsert == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Cannot create menu";
                }
                
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Food exists in the menu";
            }

            $this->info = $info;

            return $this->info;
        }
		
        public function deleteItem($food_id)
        {
            $SQLCheck = "SELECT * FROM menu_table WHERE food_id = '$food_id'";
            $qCheck = $this->conn->query($SQLCheck);

            if(($res = $qCheck->num_rows) > 0)
            {
                $SQLDelete = "DELETE FROM menu_table WHERE food_id = '$food_id'";
                $qDelete = $this->conn->query($SQLDelete);

                if($qDelete == TRUE)
                    $info["result"] = TRUE;
                else
                {
                    $info["result"] = FALSE;
                    $info["errorMsg"] = "Item cannot be deleted";
                }
            }
            else
            {
                $info["result"] = FALSE;
                $info["errorMsg"] = "Item does not exist";
            }

            $this->info = $info;

            return $this->info;
        }

        public function modifyMenu($food_id, $food_name, $food_cat, $food_desc, $price_per_unit, $stock, $images_URL)
        {
            try
            {
                $error = TRUE;

                //to check whether the name of the user profile entered exists or not
                $SQLCheckM = "SELECT * FROM menu_table WHERE food_id = '$food_id'";
                $qCheckM = $this->conn->query($SQLCheckM);

                if(($res = $qCheckM->num_rows) > 0)
                {
                    if(!empty($food_name))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateN = "UPDATE menu_table SET food_name = '$food_name' WHERE food_id = '$food_id'";
                        $qUpdateN = $this->conn->query($SQLUpdateN);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateN == FALSE)
                            $error = FALSE;
                    }

                    if(!empty($food_cat))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateS = "UPDATE menu_table SET category = '$food_cat' WHERE food_id = '$food_id'";
                        $qUpdateS = $this->conn->query($SQLUpdateS);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateS == FALSE)
                            $error = FALSE;
                    }
					
					if(!empty($food_desc))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateP = "UPDATE menu_table SET description = '$food_desc' WHERE food_id = '$food_id'";
                        $qUpdateP = $this->conn->query($SQLUpdateP);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateP == FALSE)
                            $error = FALSE;
                    }

                    if(!empty($price_per_unit))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateP = "UPDATE menu_table SET price_per_unit = '$price_per_unit' WHERE food_id = '$food_id'";
                        $qUpdateP = $this->conn->query($SQLUpdateP);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateP == FALSE)
                            $error = FALSE;
                    }
					
					if(!empty($stock))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateP = "UPDATE menu_table SET stock = '$stock' WHERE food_id = '$food_id'";
                        $qUpdateP = $this->conn->query($SQLUpdateP);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateP == FALSE)
                            $error = FALSE;
                    }
					
					if(!empty($images_URL))
					{
						//To update the informations entered by the user
                        $SQLUpdateP = "UPDATE menu_table SET images_URL = '$images_URL' WHERE food_id = '$food_id'";
                        $qUpdateP = $this->conn->query($SQLUpdateP);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateP == FALSE)
                            $error = FALSE;
					}

                    if($error == FALSE)
                        return FALSE;
                    else
                        return TRUE;
                    
                }
                else
                //Will return false if username entered does not exist
                    return FALSE;
            }
            catch(mysqli_sql_exception $e)
            {
                return FALSE;
            }

        }
    }
?>