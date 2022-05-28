<?php
    require("../Controller/suspendProfileC.php");
	require('../Controller/viewProfileC.php');
	
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/suspendprofile.js"></script>

<link rel="stylesheet" href="../css/suspendprofile.css">
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
    <a href="viewprofile.php" class="profile">
        View Profile
    </a>
    <a href="suspendprofile.php" class="profile" id="add">
        Suspend Profile
    </a>
    <a href="updateprofile.php" class="profile">
        Update Profile
    </a>
    <br>
</div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
    <input type="text" placeholder="Search..." id="myInput" onclick="showFunction()" onkeyup="filterFunction()">
	<br><br>
<form action='suspendprofile.php' method='post'>
</div>
<!-- once user clicks on a menu item from searchbar's dropdown,
    details will be auto keyed-in these inputs -->
    <div class="list">
	<?php 
	if(isset($_POST["submit"]))
        {
            $UPName = $_POST["inputSus"];

            $controller = new suspendProfileC();
            $message = $controller->suspend($UPName);

            if($message["result"] == TRUE)
                echo '<script> displaySuccess(); </script>';
            else
            {
                if($message["errorMsg"] == "Profile does not exist")
					echo '<script> alert("The profile does not exist"); </script>';
                else if($message["errorMsg"] == "Already suspended")
					echo '<script> alert("The profile is already suspended"); </script>';
				else if($message["errorMsg"] == "Cannot suspended")
					echo '<script> alert("The profile cannot be suspended"); </script>';
				else if($message["errorMsg"] == "Try again!")
					echo '<script> alert("Try again!"); </script>';
            }
			
			displayProfileList();
        } else
			displayProfileList();
		
function displayProfileList() {
	$list = new ViewProfileC();
	$profilelist= $list->viewProfiles();
	echo "<table id='table'><tr><th></th><th>Profile</th><th>Description</th><th>Menu</th><th>Orders</th>";
	echo "<th>Coupon</th><th>Profile</th><th>User</th><th>Report</th><th>Transaction</th><th>Status</th>";
	for($i = 0; $i < count($profilelist); $i++)
	{
		echo "<tr class='search_profile' contenteditable='false' value='0'>";
		echo "<td><input type='radio' name='inputSus' value='" . $profilelist[$i]["profile_name"] ."'></td>";
		echo "<td>" . $profilelist[$i]["profile_name"] . "</td>";
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
	echo "</tr></table>";
}

	function displaySuccess() {
		alert("The profile has been successfully suspended");
	}
	?>
	<br><br>
	<input type="submit" name="submit" id="deleteC" value="Suspend">
</form>
</body> 