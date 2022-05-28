<?php
    require("../Controller/modifyCouponC.php");
	require("../Controller/viewCouponC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/updatecoupon.js"></script>

<link rel="stylesheet" href="../css/updatecoupon.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">


<body>
<!-- for the heading of the website -->
    <div class="header">
        <a href="restauranthome.html">
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

<!-- allow users to move around to different pages related to user profile -->
	<div class="board">
        <!-- this para is for you guys incase yall get confused which row is for user account/ user profile -->
        <p>Coupons: </p><br>
        <a href="createcoupon.php" class="profile">
            Create Coupon
        </a>
        <a href="viewcoupon.php" class="profile">
            View Coupon
        </a>
        <a href="deletecoupon.php" class="profile">
            Suspend Coupon
        </a>
        <a href="modifycoupon.php" class="profile" id="add">
            Update Coupon
        </a>
        <br>       
    </div>

<!-- user will key in new profile's details into these inputs -->
<form action="modifycoupon.php" method="POST">
<div class="profile">
    <span class="options">
        <label for="id">Coupon Code:</label>
        <input type="text" id="id" name="id">
		<br><br>

        <label for="value">Coupon Discount: $</label>
        <input type="text" id="value" name="value" pattern="[+-]?([0-9]*[.])?[0-9]+">
        <br><br>
		<label for="stock">Coupon Stock:</label>
        <input type="text" id="stock" name="stock" pattern="[0-9]+">
		<br><br>
		<label for="start">Coupon Start:</label>
		<input type="date" id="start" name="start_date">
		<br><br>
		<label for="end">Coupon End:</label>
        <input type="date" id="end" name="end_date">
		<br><br>
		<label for="desc">Description:</label>
        <input type="text" id="desc" name="description">
		<br><br>
            
        <input type="submit" name="submit" id="modify" value="Modify"> 
    </span>
    <br><br>
</div>
</form>
<?php
function displayCouponList() {
	$coupon = new ViewCouponC();
	$list = $coupon->viewCoupon();

	echo "<table border='1' align='center'><tr><th>Coupon ID</th><th>Value</th><th>Stock</th><th>Description</th><th>Start Date</th><th>End Date</th>";
	for($i = 0; $i < count($list); $i++)
	{
		
		echo "<tr class='view_profile' contenteditable='false' value='0'>";
		echo "<td>" . $list[$i]["id"] . "</td>";
		echo "<td>" . $list[$i]["value"] . "</td>";
		echo "<td>" . $list[$i]["stock"] . "</td>";
		echo "<td>" . $list[$i]["description"] . "</td>";
		echo "<td>" . $list[$i]["start_date"] . "</td>";
		echo "<td>" . $list[$i]["end_date"] . "</td></tr>";
	}
	echo "</table>";
}
        if(isset($_POST["submit"]))
        {
            $coupon_id = $_POST["id"];

            if(isset($_POST["value"]))
			    $coupon_value = $_POST['value'];
            else
                $coupon_value = NULL;
            
            if(isset($_POST["stock"]))
                $coupon_stock = $_POST['stock'];
            else
                $coupon_stock = NULL;
			
			if(isset($_POST["start_date"]))
                $coupon_isdate = $_POST['start_date'];
            else
                $coupon_isdate = NULL;
			
			if(isset($_POST["end_date"]))
                $coupon_exdate = $_POST['end_date'];
            else
                $coupon_exdate = NULL;
			
			if(isset($_POST["description"]))
                $coupon_desc = $_POST['description'];
            else
                $coupon_desc = NULL;

            $controller = new modifyCouponC();
            $message = $controller->validateDetails($coupon_id, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc);

            if($message == TRUE) 
                displaySuccess();
            else
				displayFail();
			
			displayCouponList();
        }
		
function displaySuccess() {
	echo '<script> alert("Coupon has been updated"); </script>';
}

function displayFail() {
	echo '<script> alert("Modification failed."); </script>';
}
    ?>
</body>
</html>