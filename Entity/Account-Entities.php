<?php

class Account {
    protected $id;
    protected $name;
    protected $usrnm;
    protected $pswd;
    protected $phone;
    protected $profile;
    protected $status;
    protected $keyword;
    protected $conn;
	protected $data;

    //MAIN CONSTRUCTOR
    public function __construct() {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();
  
        if (method_exists($this, $function = 'construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
        $this->conn = mysqli_connect("localhost", "root", "", "DumbledoreDB");
    }

    //CONSTRUCTOR FOR CREATING USER ACCOUNT
    public function construct5($name, $usrnm, $pswd, $phone, $profile) {
        $this->id = 1234;
        $this->name = $name;
        $this->usrnm = $usrnm;
        $this->pswd = $pswd;
        $this->phone = $phone;
        $this->profile = $profile;
        $this->status = "Active";
    }

    //CONSTRUCTOR FOR LOGIN
    public function construct3($usrnm, $pswd, $profile) {
        $this->usrnm = $usrnm;
        $this->pswd = $pswd;
        $this->profile = $profile;
    }

    //CONSTRUCTOR FOR SEARCH KEYWORD
    public function construct1($keyword) {
        $this->keyword = $keyword;
    }
    
    //TO VERIFY LOGIN
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

    //TO VERIFY WHETHER USERNAME EXIST
    public function verifyUsername() {
        $boo;
        $sql="SELECT * FROM user_account WHERE username=?;";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "s", $this->usrnm);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_fetch_assoc($result)){
            $boo = false;
        }
    
        else{
            $boo = true;
        }
        
        return $boo;
        mysqli_stmt_close($stmt);
    }

    //TO VERIFY WHETHER PHONE NUMBER EXIST
    public function verifyPhone() {
        $boo;
        $sql="SELECT * FROM user_account WHERE phone_number=?;";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "i", $this->phone);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_fetch_assoc($result)){
            $boo = false;
        }
    
        else{
            $boo = true;
        }
        
        return $boo;
        mysqli_stmt_close($stmt);
    }

    //CREATING USER ACCOUNT
    public function addUser() {
        $sql="INSERT INTO user_account (id, full_name, username, password, phone_number, profile, status) values (?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "isssiss", $this->id, $this->name, $this->usrnm, $this->pswd, $this->phone, $this->profile, $this->status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

	public function checkSearch() {
        $boo;
        $keyword = '%'.$this->keyword.'%';
        $sql="SELECT * FROM user_account WHERE id LIKE ? OR username LIKE ?;";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(!mysqli_fetch_assoc($result)) {
            $boo = "noExist";
        }

        else {
            $boo = "Exist";
        }

        return $boo;
        mysqli_stmt_close($stmt);
    }
	
    //DISPLAY ALL USER IN VIEW USER
    public function getUsersInfo() {
        $SQLGet = "SELECT * FROM user_account group by status, profile";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                $i = 0;

                while(($Row = $qGet->fetch_assoc()) !== NULL)
                {
                    $data[$i]["id"] = $Row["id"];
                    $data[$i]["name"] = $Row["full_name"];
                    $data[$i]["usrnm"] = $Row["username"];
                    $data[$i]["pswd"] = $Row["password"];
                    $data[$i]["phone"] = $Row["phone_number"];
                    $data[$i]["profile"] = $Row["profile"];
                    $data[$i]["status"] = $Row["status"];

                    $i++;
                }
            }
            else
                $data["message"] = "No user listed";
            
            $this->data = $data;

            return $data;
    }

    //TO DISPLAY SEARCHED USER FOR VIEW USER
    public function getUserInfo($keyword) {
        $i = 0;

            //To fetch all the information about inside the user profile table
            $SQLGetU = "SELECT * from user_account";
            $qGetU = $this->conn->query($SQLGetU);
            
			if ($qGetU->fetch_assoc() == NULL)
				return NULL;
			
            while (($Row = $qGetU->fetch_assoc())!== NULL)
            {
                $usrnm = $Row["username"];

                //To do a partial search
                if(stristr($usrnm, $keyword) != FALSE)
                {
                    $this->usrnm = $Row["username"];
                    $this->name = $Row["full_name"];

                    $data[0]["result"] = "Found";
                    $data[$i]["username"] = $this->usrnm;
                    $data[$i]["full_name"] = $this->name;
                    $data[$i]["id"] = $Row["id"];
                    $data[$i]["pswd"] = $Row["password"];
                    $data[$i]["phone"] = $Row["phone_number"];
                    $data[$i]["profile"] = $Row["profile"];
                    $data[$i]["status"] = $Row["status"];
                    
					$this->data = $data;
                    $i++;
                }
            }

            return $this->data;
    }

    //TO DISPLAY SEARCHED USER FOR SUSPEND USER
    public function getSearchedSuspendUserInfo($keyword) {
        $skeyword = '%'.$keyword.'%';
        $sql="SELECT * FROM user_account WHERE id LIKE ? OR username LIKE ? AND status='Active';";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $skeyword, $skeyword);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><th><input type='radio' name='radioInput' value=". $row["id"] ."</th><td>". $row["id"] . "</td><td>"
                                                                                                . $row["full_name"] . "</td><td>"
                                                                                                . $row["username"] . "</td><td>"
                                                                                                . $row["password"] . "</td><td>"
                                                                                                . $row["phone_number"] . "</td><td>"
                                                                                                . $row["profile"] . "</td><td>"
                                                                                                . $row["status"] . "</td></tr>"; 
        }
        mysqli_stmt_close($stmt);
    }

    //TO SUSPEND USER ACCOUNT
    public function suspendUser($usrnm) {
            try
            {
                //To check whether the username exists or not
                $SQLCheckU = "SELECT * FROM user_account WHERE username = '$usrnm' AND status = 'Active'";
                $qCheckU = $this->conn->query($SQLCheckU);
    
                if(($res = $qCheckU->num_rows) > 0)
                {
                    $Row = $qCheckU->fetch_assoc();

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
                    $data["errorMsg"] = "Account does not exist";

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



//----------------------------------------------------------------------------------------------------------------------------------------------------//




//TO CHECK SEARCHED KEYWORD ESPECIALLY FOR UPDATE USER ACCOUNT
    public function checkUpdateSearch() {
        $boo;
        $sql="SELECT * FROM user_account WHERE id=? OR username=?;";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $this->keyword, $this->keyword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(!mysqli_fetch_assoc($result)) {
            $boo = "noExist";
        }

        else {
            $boo = "Exist";
        }

        return $boo;
        mysqli_stmt_close($stmt);
    }

    //TO STORE SEARCHED USER INSIDE AN ARRAY FOR UPDATE USER
    public function getUpdateUserInfo() {
        $sql="SELECT * FROM user_account WHERE id=? OR username=?;";
        $stmt = mysqli_stmt_init($this->conn);
  
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $this->keyword, $this->keyword);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        while($row = mysqli_fetch_assoc($result)) {
            
            $this->id = $row["id"];
            $this->name = $row["full_name"];
            $this->usrnm = $row["username"];
            $this->pswd = $row["password"];
            $this->phone = $row["phone_number"];
            $this->profile = $row["profile"];
            $this->status = $row["status"];  
        }

        mysqli_stmt_close($stmt);
    }

    public function displayUpdateForm() {
        $usrnm = $this->usrnm;
        echo "<form method='post'>
                <div class='profile'>
                    <span class='options'>
                        <label for='username'>Username:</label>
                            <input value=$this->usrnm type='text' id='username'>
                            <br><br>
                        
                        <label for='password'>Password:</label>
                            <input value=".$this->pswd." type='password' id='password' onfocusout='validatePassword()'>
                                <span id='passwordError'></span>
                                <br><br>

                        <label for='repassword'>Re-type Password:</label>
                            <input type='password' id='repassword' onfocusout='validateRePassword()'>
                                <span id='repasswordError'></span>
                                <br><br>

                         <label for='name'>Account Name:</label>
                            <input value=".$this->name." type='text' id='name'>
                                <br><br>
                    </span>

                <div id='describe'>
                    <label for='number'>Phone Number:</label>
                        <input value=".$this->phone." type='text' id='number' name='number' onfocusout='validateNumber()'>
                            <span id='numberError'></span>
                            <br><br>

                    <label for='profilename' id='profileimg'>User Profile:</label>
                        <select name='profilename' id='profilename'>
                            <option value='Customer'>Customer</option>
                            <option selected value='Useradmin'>User Admin</option>
                            <option value='Manager'>Restaurant Manager</option>
                            <option value='Owner'>Owner</option>
                        </select>
                        <br><br><br>
          
                <span><button id='submit'>Update Account</button></span>
                </div>
                <br>
                       
                </div>
             </form>";
    }
}