<?php
	session_start();
    require("../Controller/createOrderC.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/createmenu.js"></script>

<link rel="stylesheet" href="../css/createmenu.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">

<body>
<!-- for the heading of the website -->
    <div class="header">
    <a href="staffhome.html">
            Dumbledore House
        </a>
        <span class="username">
            Welcome
<!-- to allow user to click on the user icon to logout -->
            <div class="dropdown">
                <button class="dropbtn"><img src="../pictures/apple.png"></button>
                <div class="dropdown-content">
                  <button>User Profile</button>
                  <button>Settings</button>
                  <button onclick="displayAlert()";>Logout</button>
                </div>
              </div>
        </span>
    </div> 

<br>
        <span class="options">
            <form action="createorder.php" method="POST">
			<br><br><br><br>
            <label for="tableno">Table No:</label>
            <input type="text" id="table_num" name="table_num">
            <br><br>

            <label for="orderid">Order ID:</label>
            <input type="text" name="order_id" id="order_id">
            <br><br>

            <label for="staffid">Staff ID:</label>
            <input type="text" name="staff_id" id="staff_id">
            <br><br>

        <br>
    </span>
    <!-- <input type="submit" name="create" value="Create New Item">   -->
    <button name="create" type="submit" id="createbutton">
       Browse Menu
    </button> 
    </form>     

<?php
    if(isset($_POST["create"]))
    {
        if(trim($_POST["order_id"]) == "")
            $order_id = "";
        else
            $order_id = $_POST["order_id"];
        
        $table_num = $_POST["table_num"];
        $staff_id = $_POST["staff_id"];

        $controller = new CreateOrderC();
        $result = $controller->validateDetails($order_id, $table_num, $staff_id);
		
		if($result == FALSE) {
			$fail = "All information must be number";
			displayFail($fail);
		}
        else if($result["result"] == FALSE) {
            $fail = $result["errorMsg"];
			displayFail($fail);
        } 
		else
        {
            if(trim($order_id) == "")
                $_SESSION["order_id"] = $result["id"];
            else
                $_SESSION["order_id"] = $order_id;
            
            $_SESSION["table_num"] = $table_num;
            $_SESSION["staff_id"] = $staff_id;

            header("Location: ../Boundary/order.php");
        }
    }
	
	function displayFail($fail) {
		echo '<script> alert("' . $fail . '") </script>';
	}
?>
</body>
</html>