<?php
    class Account
    {
        protected $conn = NULL;
        protected $usrnm;
        protected $pswd;
		protected $phone;
        protected $name;
        protected $profile;
		protected $status;
        protected $data;

        function __construct()
        {
            //To initialize the connection to the database in PhpMyAdmin
            $conn = @new mysqli("localhost", "root", "", "DumbledoreDB");

            //To initilize all the instance variables of the class
            $this->conn = $conn;
            $this->usrnm = "";
            $this->pswd = "";
			$this->phone = 0;
			$this->profile = "";
			$this->name = "";
			$this->status = "Active";
            $this->data = array();
        }
		
		public function construct3($usrnm, $pswd, $profile) {
			$this->usrnm = $usrnm;
			$this->pswd = $pswd;
			$this->profile = $profile;
		}
		
		public function verifyLogin() {
			$boo;
			$sql="SELECT * FROM user_account WHERE profile=? AND username=? AND password=? AND status='Active';";
			$stmt = mysqli_stmt_init($this->conn);
			
			if(!mysqli_stmt_prepare($stmt, $sql)){
				exit();
			} 
		
			mysqli_stmt_bind_param($stmt, "sss", $this->profile, $this->usrnm, $this->pswd);
			mysqli_stmt_execute($stmt);
		
			$result = mysqli_stmt_get_result($stmt);
			
			if(!mysqli_num_rows($result)){
				$boo = "invalidLogin";
			}
			else{
				$boo = "validLogin";
			}

			return $boo;
			mysqli_stmt_close($stmt);
		}
		
        public function addUser($usrnm, $pswd, $phone, $profile, $name)
        {
            $this->usrnm = $usrnm;
            $this->pswd = $pswd;
            $this->phone = $phone;
			$this->profile = $profile;
			$this->name = $name;

            try
            {   
				if(empty($this->usrnm)||empty($this->pswd)||empty($this->phone)||empty($this->profile)||empty($this->name))
				{	
					$data["result"] = FALSE;
					$data["errorMsg"] = "Please fill in the necessary information";
					
					$this->data = $data;
					return $this->data;
				}	
					
                //To check if the username or phone exists or not
                $SQLCheckP = "SELECT * FROM user_account WHERE username = '$this->usrnm' OR phone_number = '$this->phone'";
                $qCheckP = $this->conn->query($SQLCheckP);

                if(($res = $qCheckP->num_rows) == 0)
                {   
                    //To insert the name, desc, and status first
                    $SQLInsert = "INSERT INTO user_account(username, password, phone_number, profile, full_name, status) " . 
                                 "VALUES ('$this->usrnm', '$this->pswd', '$this->phone', '$this->profile', '$this->name', 'Active')";
                    $qInsert = $this->conn->query($SQLInsert);

                    if($qInsert == TRUE)
                    {   
                        $data["result"] = TRUE;
                    }    
                    else
                    {
                        $data["result"] = FALSE;
                        $data["errorMsg"] = "Cannot create";
                    }

                    $this->data = $data;

                    return $data;
                }
                else
                {
                    $data["result"] = FALSE;
                    $data["errorMsg"] = "Username already exists";

                    return $data;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                //To ensure that the instance variables is empty if there is an error detected
                $this->usrnm = "";
                $this->pswd = "";
                $this->phone = 0;
				$this->name = "";
				$this->profile = "";
				$this->status = "Active";
            }
        }

        public function updateUser($usrnm, $pswd, $phone, $name, $profile, $status)
        {
            //To assign the values in the parameter into the instance variables
            $this->usrnm = $usrnm;
            $this->pswd = $pswd;
			$this->phone = $phone;
            $this->name = $name;
			$this->profile = $profile;
			$this->status = $status;

            try
            {
                $error = TRUE;

                //to check whether the name of the user profile entered exists or not
                $SQLCheckP = "SELECT * FROM user_account WHERE username = '$this->usrnm'";
                $qCheckP = $this->conn->query($SQLCheckP);

                if(($res = $qCheckP->num_rows) > 0)
                {
                    if(!empty($this->name))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateN = "UPDATE user_account SET full_name = '$this->name' WHERE username = '$this->usrnm'";
                        $qUpdateN = $this->conn->query($SQLUpdateN);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateN == FALSE)
                            $error = FALSE;
                    }

                    if(!empty($status))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateS = "UPDATE user_account SET status = '$this->status' WHERE username = '$this->usrnm'";
                        $qUpdateS = $this->conn->query($SQLUpdateS);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateS == FALSE)
                            $error = FALSE;
                    }
					
					if(!empty($pswd))
                    {
                        //To update the informations entered by the user
                        $SQLUpdateP = "UPDATE user_account SET password = '$this->pswd' WHERE username = '$this->usrnm'";
                        $qUpdateP = $this->conn->query($SQLUpdateP);

                        //Will return true if the update succedeed & false if not
                        if($qUpdateP == FALSE)
                            $error = FALSE;
                    }

                    if(!empty($profile))
                    {
                        $qGetP = $this->conn->query("SELECT profile_name FROM user_profile");
						if(($res = $qGetP->num_rows) > 0) {
							while(($Row = $qGetP->fetch_assoc())!== NULL)
								$profilelist[] = $Row['profile_name'];
						}
						else {
							return FALSE; //no profile listed
						}
						
						if(!in_array($profile, $profilelist))
							$error = FALSE; //no match profile
						else {
							$qUpdateP = $this->conn->query("UPDATE user_account SET profile = '$this->profile' WHERE username = '$this->usrnm'");
							
							if($qUpdateP == FALSE)
                            $error = FALSE;
						}
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
                //To ensure that the instance variables is empty if there is an error detected
                $this -> usrnm = "";
                $this -> pswd = "";
                $this -> status = "Active";
				$this -> name = "";
				$this -> profile = "";

                return FALSE;
            }

        }

        public function suspendUser($usrnm)
        {
            try
            {
                //To check whether the user profile name exists or not
                $SQLCheckP = "SELECT * FROM user_account WHERE username = '$usrnm' AND status = 'Active'";
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
                        $SQLSuspend = "UPDATE user_account SET status = 'Suspended' WHERE username = '$usrnm'";
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
                $this -> usrnm = "";
                $data["result"] = false;
                $data["errorMsg"] = "Try again";

                return $data;                
            }
        }

        public function getUserInfo($keyword)
        {
            $i = 0;

            //To fetch all the information about inside the user profile table
            $SQLGetP = "SELECT * from user_account";
            $qGetP = $this->conn->query($SQLGetP);
			
            while (($Row = $qGetP->fetch_assoc())!== NULL)
            {
                $usrnm = $Row["username"];
				$id = $Row["id"];

                //To do a partial search
                if(stristr($usrnm, $keyword) != FALSE || ($id == $keyword))
                {
                    $data[0]["result"] = "Found";
                    $data[$i]["usrnm"] = $Row["username"];
                    $data[$i]["id"] = $Row["id"];
                    $data[$i]["name"] = $Row["full_name"];
                    $data[$i]["phone"] = $Row["phone_number"];
                    $data[$i]["profile"] = $Row["profile"];
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

        public function getUsersInfo()
        {
            $SQLGet = "SELECT * FROM user_account group by status, profile, id";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                $i = 0;

                while(($Row = $qGet->fetch_assoc()) !== NULL)
                {
                    $data[$i]["id"] = $Row["id"];
                    $data[$i]["usrnm"] = $Row["username"];
                    $data[$i]["name"] = $Row["full_name"];
                    $data[$i]["phone"] = $Row["phone_number"];
                    $data[$i]["profile"] = $Row["profile"];
                    $data[$i]["status"] = $Row["status"];;

                    $i++;
                }
            }
            else
                $data["message"] = "No user listed";
            
            $this->data = $data;

            return $data;
        } 
    }
?>