<?php 
    require("../Controller/viewEmailC.php") 
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>

<link rel="stylesheet" href="../css/viewemail.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">


<body>
<!-- for the heading of the website -->
    <div class="header">
        <a href="ownerhome.html">
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
        <a href="viewemail.php" class="owner">
            View Email Record
        </a>
        <a href="viewmenu.php" class="owner">
            Generate Report
		</a>
    </div>
<?php 
displayRecord();

function displayRecord() {
	$list = new viewEmailC();
	$emaillist= $list->viewRecord();
	echo "<table border='1' class='center'><tr><th>Email</th><th>Order ID</th><th>Transaction Date</th>";
	for($i = 0; $i < count($emaillist); $i++)
	{
		echo "<tr><td>" . $emaillist[$i]["email"] . "</td>";
		echo "<td>" . $emaillist[$i]["order_id"] . "</td>";
		echo "<td>" . $emaillist[$i]["transaction_date"] . "</td>";
	}
	echo "</table>";
}
?>
</body>