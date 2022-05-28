<?php 
	require("../Controller/viewCouponC.php");
	require("../Controller/searchCouponC.php"); 
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>

<link rel="stylesheet" href="../css/viewcoupon.css">
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

<!-- allow users to move around to different pages related to menu item -->
    <div class="board">
        <p>Coupons: </p><br>
        <a href="createcoupon.php" class="profile">
            Create Coupon
        </a>
        <a href="viewcoupon.php" class="profile" id="add">
            View Coupon
        </a>
        <a href="deletecoupon.php" class="profile">
            Suspend Coupon
        </a>
        <a href="modifycoupon.php" class="profile">
            Update Coupon
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
    <form method='post'>
    <input type="text" placeholder="Search.." id="myInput" name="myInput" onclick="showFunction()" onkeyup="filterFunction()">
	<input type="submit" name="submit" value="Search">
	</form>
</div>

<?php
if(isset($_POST['submit']))
	displayCouponInfo();
else
	displayAllCoupons();

function displayCouponInfo() {
	$coupon = new SearchCouponC();
	$list = $coupon->checkKeyword($_POST['myInput']);
	if($list != NULL) {
		echo "<table id='table' align='center'><tr><th>Coupon ID</th><th>Value</th><th>Stock</th><th>Description</th><th>Start Date</th><th>End Date</th>";
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
	} else {
		displayNotFound();
	}
}

function displayNotFound() {
	echo "No record found";
}

function displayAllCoupons() {
	$coupon = new ViewCouponC();
	$list = $coupon->viewCoupon();

	echo "<table id='table' align='center'><tr><th>Coupon ID</th><th>Value</th><th>Stock</th><th>Description</th><th>Start Date</th><th>End Date</th>";
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
?>
    </div>
    </form>
</body> 