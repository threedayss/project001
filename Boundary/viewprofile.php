<?php require("../Controller/viewProfileC.php");
require("../Controller/searchProfileC.php"); ?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/viewprofile.js"></script>

<link rel="stylesheet" href="../css/viewprofile.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">


<body>
<!-- for the heading of the website -->
    <div class="header">
        <a href="../Boundary/home.html">
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
        <span>User Profiles</span><br><br>
        <a href="createprofile.php" class="profile">
            Add Profile
        </a>
        <a href="viewprofile.php" class="profile" id="add">
            View Profile
        </a>
        <a href="suspendprofile.php" class="profile">
            Suspend Profile
        </a>
        <a href="updateprofile.php" class="profile">
            Update Profile
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
	displayProfileInfo();
else
	displayAllProfiles();

function displayProfileInfo() {
	$profile = new SearchProfileC();
	$info = $profile->checkKeyword($_POST['myInput']);
	if($info != NULL) {
		echo "<table border='1' align='center'><tr><th>Profile</th><th>Description</th><th>Menu</th><th>Orders</th>";
		echo "<th>Coupon</th><th>Profile</th><th>User</th><th>Report</th><th>Transaction</th><th>Status</th></tr>";
		for($i = 0; $i < count($info); $i++)
		{
			echo "<tr><td>" . $info[$i]["profileName"] . "</td>";
			echo "<td>" . $info[$i]["description"] . "</td>";
			echo "<td>" . $info[$i]["menu"] . "</td>";
			echo "<td>" . $info[$i]["orders"] . "</td>";
			echo "<td>" . $info[$i]["coupon"] . "</td>";
			echo "<td>" . $info[$i]["profile"] . "</td>";
			echo "<td>" . $info[$i]["user"] . "</td>";
			echo "<td>" . $info[$i]["report"] . "</td>";
			echo "<td>" . $info[$i]["transactions"] . "</td>";
			echo "<td>" . $info[$i]["status"] . "</td>";
		}
	} else {
		displayNotFound();
	}
}

function displayNotFound() {
	echo "No record found";
}

function displayAllProfiles() {
	$list = new ViewProfileC();
	$profilelist= $list->viewProfiles();
	echo "<table border='1'><tr><th>Profile</th><th>Description</th><th>Menu</th><th>Orders</th>";
	echo "<th>Coupon</th><th>Profile</th><th>User</th><th>Report</th><th>Transaction</th><th>Status</th></tr>";
	for($i = 0; $i < count($profilelist); $i++)
	{
		echo "<tr><td>" . $profilelist[$i]["profile_name"] . "</td>";
		echo "<td>" . $profilelist[$i]["description"] . "</td>";
		echo "<td>" . $profilelist[$i]["menu"] . "</td>";
		echo "<td>" . $profilelist[$i]["orders"] . "</td>";
		echo "<td>" . $profilelist[$i]["coupon"] . "</td>";
		echo "<td>" . $profilelist[$i]["profile"] . "</td>";
		echo "<td>" . $profilelist[$i]["user"] . "</td>";
		echo "<td>" . $profilelist[$i]["report"] . "</td>";
		echo "<td>" . $profilelist[$i]["transaction"] . "</td>";
		echo "<td>" . $profilelist[$i]["status"] . "</td>";
	}
	echo "</table>";
}
?>
</body>