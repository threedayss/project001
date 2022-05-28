<?php 
require("../Controller/deleteCouponC.php");
require("../Controller/viewCouponC.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/deletecoupon.js"></script>

<link rel="stylesheet" href="../css/deletecoupon.css">
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
                  <button onclick="displayAlert()";>Logout</button>
                </div>
              </div>
        </span> 
    </div>

<!-- allow users to move around to different pages related to menu item -->
    <div class="board">
        <span>Coupon</span><br><br>
        <a href="createcoupon.php" class="profile">
            Create Coupon
        </a>
        <a href="viewcoupon.php" class="profile">
            View Coupon
        </a>
        <a href="deletecoupon.php" class="profile" id="add">
            Suspend Coupon
        </a>
        <a href="modifycoupon.php" class="profile">
            Modify Coupon
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
    <input type="text" placeholder="Search..." id="myInput" onclick="showFunction()" onkeyup="filterFunction()">
	<br><br>
<form action='deletecoupon.php' method='post'>
</div>
<!-- once user clicks on a menu item from searchbar's dropdown,
    details will be auto keyed-in these inputs -->
    <div class="list">
	<?php 
	if(isset($_POST["submit"]))
        {
            $coupon_id = $_POST["input"];

            $controller = new DeleteCouponC();
            $message = $controller->deleteItem($coupon_id);

            if($message["result"] == TRUE)
                displaySuccess();
            else
            {
                $fail = $message['errorMsg'];
				displayFail($fail);
            }
			
			displayAllCoupons();
        } else
			displayAllCoupons();
		
function displayAllCoupons() {
	$list = new ViewCouponC();
	$couponlist= $list->viewCoupon();
	echo "<table border='1' align='center'><tr><th></th><th>Coupon ID</th><th>Value</th><th>Stock</th><th>Description</th><th>Start Date</th><th>End Date</th>";
	for($i = 0; $i < count($couponlist); $i++)
	{
		echo "<tr class='search_profile' contenteditable='false' value='0'>";
		echo "<td><input type='radio' name='input' value='" . $couponlist[$i]["id"] ."'></td>";
		echo "<td>" . $couponlist[$i]["id"] . "</td>";
		echo "<td>" . $couponlist[$i]["value"] . "</td>";
		echo "<td>" . $couponlist[$i]["stock"] . "</td>";
		echo "<td>" . $couponlist[$i]["description"] . "</td>";		
		echo "<td>" . $couponlist[$i]["start_date"] . "</td>";
		echo "<td>" . $couponlist[$i]["end_date"] . "</td>";
	}
	echo "</tr></table>";
}

function displaySuccess() {
	echo '<script> alert("Coupon has been successfully removed"); </script>';
}

function displayFail($fail) {
	echo '<script> alert("' . $fail . '"); </script>';
}
	?>
	<br><br>
	<input type="submit" name="submit" id="deleteC" value="Delete">
</form>
</body> 