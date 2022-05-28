<?php 
	require('../Controller/searchOrderC.php');
	require ('../Controller/viewHistoryC.php'); 
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/viewmenu.js"></script>

<link rel="stylesheet" href="../css/viewmenu.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">

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
                  <button onclick='displayAlert()';>Logout</button>
                </div>
              </div>
        </span> 
    </div>

<!-- allow users to move around to different pages related to menu item -->
    <div class="board">
        <a href="createorder.php" class="profile">
            Create Order
        </a>
        <a href="allorder.php" class="profile">
            Check Progress
        </a>
        <a href="viewOrderHistory.php" class="profile"  id="add">
            View Order History
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
	<form method='post'>
    <input type="text" placeholder="Search..." id="myInput" name="myInput" onclick="showFunction()">
	<input type="submit" name="submit" id="searchM" value="Search">
	</form>
</div>
	<?php 
	if(isset($_POST['submit']))
		displayHistoryInfo();
	else
		displayAllHistory();
	
	function displayHistoryInfo() {
		$controller = new SearchOrderC();
        $historylist = $controller->checkKeyword($_POST['myInput']);
		if($historylist != NULL) {
			echo "<table border='1' align='center'><tr><th>Transaction Date</th><th>Order ID</th><th>Table Number</th><th>Food ID & Quantity</th><th>Subtotal</th>";
			for($i = 0; $i < count($historylist); $i++)
			{
				echo "<tr class='search_profile' contenteditable='false' value='0'>";
				echo "<td>" . $historylist[$i]["date"] . "</td>";
				echo "<td>" . $historylist[$i]["order_id"] . "</td>";
				echo "<td>" . $historylist[$i]["table_num"] . "</td>";
				echo "<td>" . $historylist[$i]["info"] . "</td>";
				echo "<td>" . $historylist[$i]["total"] . "</td>";
			}
		echo "</tr></table>";
		} else {
			displayNotFound();
		}
	}
	
	function displayNotFound() {
		echo "No record found";
	}
	
	function displayAllHistory() {
		$list = new ViewHistoryC();
		$historylist= $list->viewHistory();
		echo "<table border='1' align='center'><tr><th>Transaction Date</th><th>Order ID</th><th>Table Number</th><th>Food ID & Quantity</th><th>Subtotal</th>";
		for($i = 0; $i < count($historylist); $i++)
		{
			echo "<tr class='search_profile' contenteditable='false' value='0'>";
			echo "<td>" . $historylist[$i]["date"] . "</td>";
			echo "<td>" . $historylist[$i]["order_id"] . "</td>";
			echo "<td>" . $historylist[$i]["table_num"] . "</td>";
			echo "<td>" . $historylist[$i]["info"] . "</td>";
			echo "<td>" . $historylist[$i]["total"] . "</td>";
		}
		echo "</tr></table>";
	}
	?>
	</div>
</body> 