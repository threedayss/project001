<?php
    class Profile
    {
        protected $conn = NULL;
        protected $UPName;
        protected $desc;
		protected $status;
        protected $functions;
        protected $indication;
        protected $data;

        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            //To initilize all the instance variables of the class
            $this->conn = $conn;
            $this->UPName = "";
            $this->desc = "";
			$this->status = "Active";
            $this->functions = array();
            $this->indication = 0;
            $this->data = array();
        }

        public function addProfile($UPName, $desc, $functions)
        {
            $this->UPName = $UPName;
            $this->desc = $desc;
            $this->functions = $functions;

            try
            {   
                //To check if the profile name exists or not
                $SQLCheckP = "SELECT * FROM user_profile WHERE profile_name = '$this->UPName'";
                $qCheckP = $this->conn->query($SQLCheckP);

                if(($res = $qCheckP->num_rows) == 0)
                {   
                    //To insert the name, desc, and status first
                    $SQLInsert = "INSERT INTO user_profile(profile_name, description, menu, orders, coupon, profile, user, report, transaction, status)" . 
                                 "VALUES ('$this->UPName', '$this->desc', 0, 0, 0, 0, 0, 0, 0, 'Active')";
                    $qInsert = $this->conn->query($SQLInsert);

                    if($qInsert == TRUE)
                    {   
                        if(!empty($functions))
                        {
                            $check = TRUE;

                            foreach($functions as $function)
                            {
                                if(!empty($function))
                                {
                                    //To set its functions/priveleges
                                    $SQLFunctions = "UPDATE user_profile SET $function = 1 WHERE profile_name = '$this->UPName'";
                                    $qFunctions = $this->conn->query($SQLFunctions);
        
                                    if($qFunctions == TRUE)
                                        $check = TRUE;
                                        // $data["result"] = TRUE;
                                    else
                                    {
                                        //To delete the profile from the database if the functions cannot be set
                                        $SQLDelete = "DELETE FROM user_profile WHERE profile_name = '$this->UPName'";
                                        $qDelete = $this->conn->query($SQLDelete);
                                            
                                        $check = FALSE;
                                            // $data["result"] = FALSE;
                                            // $data["errorMsg"] = "Cannot update functions";
                                    }
                                }
                                
                            }

                            if($check == FALSE)
                            {
                                $data["result"] = FALSE;
                                $data["errorMsg"] = "Cannot update functions";
                            }
                            else
                                $data["result"] = TRUE;

                            $this->data = $data;

                            return $this->data;
                        }
                        else
                        {
                            $data["result"] = TRUE;

                            $this->data = $data;
                            return $this->data;
                        }
                    }    
                    else
                    {
                        $data["result"] = FALSE;
                        $data["errorMsg"] = "Cannot create";

                        return $data;
                    }

                    $this->data = $data;

                    return $data;
                }
                else
                {
                    $data["result"] = FALSE;
                    $data["errorMsg"] = "Profile exists";

                    return $data;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                //To ensure that the instance variables is empty if there is an error detected
                $this -> UPName = "";
                $this -> desc = "";
                $this -> functions = "";
            }
        }

        public function updateProfile($UPName, $desc, $status)
        {
            //To assign the values in the parameter into the instance variables
            $this->UPName = $UPName;
            $this->desc = $desc;
			$this->status = $status;

            try
            {
                //to check whether the name of the user profile entered exists or not
                $SQLCheckP = "SELECT * FROM user_profile WHERE profile_name = '$this->UPName'";
                $qCheckP = $this->conn->query($SQLCheckP);

                if(($res = $qCheckP->num_rows) > 0)
                {
                    //To update the informations entered by the user
                    $SQLUpdate = "UPDATE user_profile SET description = '$this->desc', status = '$this->status' WHERE profile_name = '$this->UPName'";
                    $qUpdate = $this->conn->query($SQLUpdate);

                    //Will return true if the update succedeed & false if not
                    if($qUpdate == TRUE)
                        return TRUE;
                    else
                        return FALSE;
                }
                else
                //Will return false if user profile entered does not exist
                    return FALSE;
            }
            catch(mysqli_sql_exception $e)
            {
                //To ensure that the instance variables is empty if there is an error detected
                $this -> UPName = "";
                $this -> desc = "";
                $this -> status = "";

                return FALSE;
            }

        }

        public function suspendProfile($UPName)
        {
            //To assign the user profile name entered into the instance variables
            // $this->UPName = $UPName;

            try
            {
                //To check whether the user profile name exists or not
                $SQLCheckP = "SELECT * FROM user_profile WHERE profile_name = '$UPName' AND status = 'Active'";
                $qCheckP = $this->conn->query($SQLCheckP);
    
                if(($res = $qCheckP->num_rows) > 0)
                {
                    $Row = $qCheckP->fetch_assoc();

                    if($Row["status"] == "Suspended")
                    {
                        //To check whether the account is already suspended or not
                        $data["result"] = false;
                        $data["errorMsg"] = "Already suspended";

                        return $data;
                    }
                    else
                    {
                        //To change the status from Active to Suspended
                        $SQLSuspend = "UPDATE user_profile SET status = 'Suspended' WHERE profile_name = '$UPName'";
                        $qSuspend = $this->conn->query($SQLSuspend);

                        //Will return true if the update succedeed & false if not
                        if($qSuspend === false)
                        {
                            $data["result"] = false;
                            $data["errorMsg"] = "Cannot suspended";

                            return $data;
                        }
                        else
                        {
                            //To indicate that the account has successfully been suspended
                            $data["result"] = true;

                            return $data;
                        }
                    }                     
                }
                else
                {
                    //Will return false if user profile entered does not exist
                    $data["result"] = false;
                    $data["errorMsg"] = "Already suspended";

                    return $data;
                }

                $conn -> close();
            }
            catch(mysqli_sql_exception $e)
            {
                //To ensure that the instance variable is empty if there is an error detected
                $this -> UPName = "";
                $data["result"] = false;
                $data["errorMsg"] = "Try again";

                return $data;                
            }
        }

        public function getProfileInfo($keyword)
        {
            $i = 0;

            //To fetch all the information about inside the user profile table
            $SQLGetP = "SELECT * from user_profile";
            $qGetP = $this->conn->query($SQLGetP);
			
            while (($Row = $qGetP->fetch_assoc())!== NULL)
            {
                $profileName = $Row["profile_name"];

                //To do a partial search
                if(stristr($profileName, $keyword) != FALSE)
                {
                    $this->UPName = $Row["profile_name"];
                    $this->desc = $Row["description"];

                    $data[0]["result"] = "Found";
                    $data[$i]["profileName"] = $this->UPName;
                    $data[$i]["description"] = $this->desc;
                    $data[$i]["menu"] = $Row["menu"];
                    $data[$i]["orders"] = $Row["orders"];
                    $data[$i]["coupon"] = $Row["coupon"];
                    $data[$i]["profile"] = $Row["profile"];
                    $data[$i]["user"] = $Row["user"];
                    $data[$i]["report"] = $Row["report"];
                    $data[$i]["transactions"] = $Row["transaction"];
                    $data[$i]["status"] = $Row["status"];
                    
					$this->data = $data;
                    $i++;
                }
            }
			
			if($i == 0)
				return NULL;

			$this->data = $data;
            return $this->data;
        }

        public function getProfilesInfo()
        {
            $SQLGet = "SELECT * FROM user_profile group by status, profile_name";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                $i = 0;

                while(($Row = $qGet->fetch_assoc()) !== NULL)
                {
                    $data[$i]["profile_name"] = $Row["profile_name"];
                    $data[$i]["description"] = $Row["description"];
                    $data[$i]["menu"] = $Row["menu"];
                    $data[$i]["orders"] = $Row["orders"];
                    $data[$i]["coupon"] = $Row["coupon"];
                    $data[$i]["profile"] = $Row["profile"];
                    $data[$i]["user"] = $Row["user"];
                    $data[$i]["report"] = $Row["report"];
                    $data[$i]["transaction"] = $Row["transaction"];
                    $data[$i]["status"] = $Row["status"];

                    $i++;
                }
            }
            else
                $data["message"] = "No profile listed";
            
            $this->data = $data;

            return $data;
        }
    }
?>