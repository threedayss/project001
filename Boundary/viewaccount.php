<?php require("../Controller/viewAccountC.php");
require("../Controller/searchAccountC.php"); ?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>

<link rel="stylesheet" href="../css/viewuser.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">

<body>
<!-- for the heading of the website -->
    <div class="header">
        <a href="home.html">
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
        <span>User Accounts</span><br><br>
        <a href="createaccount.php" class="profile">
            Add User
        </a>
        <a href="viewaccount.php" class="profile" id="add">
            View User
        </a>
        <a href="suspendaccount.php" class="profile">
            Suspend User
        </a>
        <a href="updateaccount.php" class="profile">
            Update User
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be employee's id with name -->
    <div class="drop">
		<form method='post'>
        <input type="text" placeholder="Search.." id="myInput" name="myInput" onclick="showFunction()" onkeyup="filterFunction()">
		<input type="submit" name="submit" value="Search">
		</form>
	</div>
<?php 
if(isset($_POST['submit']))
	displayUserInfo();
else
	displayAllUsers();

function displayUserInfo() {
	$list = new SearchAccountC();
	$info = $list->checkKeyword($_POST['myInput']);
	if($info != NULL) {
		echo "<table border='1' align='center'><tr><th>User ID</th><th>Username</th><th>Name</th><th>Phone</th>";
		echo "<th>Profile</th><th>Status</th></tr>";
		for($i = 0; $i < count($info); $i++)
		{
			echo "<tr><td>" . $info[$i]["id"] . "</td>";
			echo "<td>" . $info[$i]["usrnm"] . "</td>";
			echo "<td>" . $info[$i]["name"] . "</td>";
			echo "<td>" . $info[$i]["phone"] . "</td>";
			echo "<td>" . $info[$i]["profile"] . "</td>";
			echo "<td>" . $info[$i]["status"] . "</td>";
		}
	} else {
		displayNotFound();
	}
}

function displayNotFound() {
	echo "No record found";
}
 
function displayAllUsers() {
	$info = new ViewAccountC();
	$list= $info->viewUsers();
	echo "<table border='1' align='center'><tr><th>User ID</th><th>Username</th><th>Name</th><th>Phone</th>";
	echo "<th>Profile</th><th>Status</th></tr>";
	for($i = 0; $i < count($list); $i++)
	{
		echo "<tr><td>" . $list[$i]["id"] . "</td>";
		echo "<td>" . $list[$i]["usrnm"] . "</td>";
		echo "<td>" . $list[$i]["name"] . "</td>";
		echo "<td>" . $list[$i]["phone"] . "</td>";
		echo "<td>" . $list[$i]["profile"] . "</td>";
		echo "<td>" . $list[$i]["status"] . "</td>";
	}
	echo "</table>";
}
?>
</body>