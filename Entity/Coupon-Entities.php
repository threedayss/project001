<?php

class Coupon {
    protected $coupon_code;
    protected $coupon_value;
    protected $coupon_stock;
    protected $coupon_isdate;
    protected $counpon_exdate;
    protected $coupon_desc;
    protected $keyword;
	protected $info;
    protected $conn;

    public function __construct() {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();
  
        if (method_exists($this, $function = 'construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
        $this->conn = mysqli_connect("localhost", "root", "", "DumbledoreDB");
		$this->info = array();
    }

    //FOR CREATING COUPON
    public function construct6($coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc) {
        $this->coupon_code = $coupon_code;
        $this->coupon_value = $coupon_value;
        $this->coupon_stock = $coupon_stock;
        $this->coupon_isdate = date("Y-m-d", strtotime($coupon_isdate));
        $this->coupon_exdate = date("Y-m-d", strtotime($coupon_exdate));
        $this->coupon_desc = $coupon_desc;
    }


    //TO CHECK IF COUPON EXIST
    public function verifyCoupon($coupon_code) {
        $boo;
        $sql="SELECT * FROM coupon_table WHERE coupon_id=?;";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            exit();
        } 
    
        mysqli_stmt_bind_param($stmt, "s", $coupon_code);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result)){
            $boo = "createInvalid";
        }
        else{
            $boo = "createValid";
        }

        return $boo;
        mysqli_stmt_close($stmt);
    }

    //TO CREATE COUPON
    public function createCoupon($coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc) {
        $boo;
		$sql="INSERT INTO coupon_table (coupon_id, value, stock, start_date, end_date, description) values (?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($this->conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: create-user-boundary.php?error= An Error in mysql stmt");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sdisss", $coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc);
        mysqli_stmt_execute($stmt);
		$boo = "createValid";
		
        mysqli_stmt_close($stmt);
		
		return $boo;
    }

    //DISPLAY ALL COUPON IN VIEW COUPON
    public function displayAllCoupons() {
		$SQLGet = "SELECT * FROM coupon_table group by coupon_id";
            $qGet = $this->conn->query($SQLGet);

            if(($res = $qGet->num_rows) > 0)
            {
                $i = 0;

                while(($row = $qGet->fetch_assoc()) !== NULL)
                {
                    $info[$i]['id'] = $row['coupon_id'];
					$info[$i]['value'] = $row['value'];
					$info[$i]['stock'] = $row['stock'];
					$info[$i]['description'] = $row['description'];
					$info[$i]['start_date'] = $row['start_date'];
					$info[$i]['end_date'] = $row['end_date'];

                    $i++;
                }
            }
            else
                $info["message"] = "No coupon listed";
            
            $this->info = $info;
			return $this->info;
    }

    //TO CHECK SEARCHED KEYWORD
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

    //TO DISPLAY SEARCHED COUPON FOR VIEW COUPON
    public function getCouponInfo($keyword) {
        $i = 0;
			
            $SQLCheck = "SELECT * FROM coupon_table";
            $qCheck = $this->conn->query($SQLCheck);

            while(($row=$qCheck->fetch_assoc()) != NULL)
            {
                $id = $row["coupon_id"];

                if(stristr($id, $keyword) != FALSE)
                {
                    $info[$i]['id'] = $row['coupon_id'];
					$info[$i]['value'] = $row['value'];
					$info[$i]['stock'] = $row['stock'];
					$info[$i]['description'] = $row['description'];
					$info[$i]['start_date'] = $row['start_date'];
					$info[$i]['end_date'] = $row['end_date'];
                    
                    $i++;
                }
            }
			
			if($i == 0)
				return NULL;
			
			$this->info = $info;
            return $this->info;
    }
	
	public function deleteItem($coupon_id)
    {
        $SQLCheck = "SELECT * FROM coupon_table WHERE coupon_id = '$coupon_id'";
        $qCheck = $this->conn->query($SQLCheck);

        if(($res = $qCheck->num_rows) > 0)
        {
            $SQLDelete = "DELETE FROM coupon_table WHERE coupon_id = '$coupon_id'";
            $qDelete = $this->conn->query($SQLDelete);

            if($qDelete == TRUE)
			   $info["result"] = TRUE;
			else
			{
				$info["result"] = FALSE;
				$info["errorMsg"] = "Coupon cannot be deleted";
			}
        }
        else
	    {
		   $info["result"] = FALSE;
		   $info["errorMsg"] = "Coupon does not exist";
		}

		$this->info = $info;

		return $this->info;
	}
}