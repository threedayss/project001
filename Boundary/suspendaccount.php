<?php
    require("../Controller/suspendAccountC.php");
	require('../Controller/viewAccountC.php');
	
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/suspenduser.js"></script>

<link rel="stylesheet" href="../css/suspenduser.css">
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
        <a href="viewaccount.php" class="profile">
            View User
        </a>
        <a href="suspendaccount.php" class="profile" id="add">
            Suspend User
        </a>
        <a href="updateaccount.php" class="profile">
            Update User
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
    <input type="text" placeholder="Search..." id="myInput" onclick="showFunction()" onkeyup="filterFunction()">
	<br><br>
<form action='suspendaccount.php' method='post'>
</div>
<!-- once user clicks on a menu item from searchbar's dropdown,
    details will be auto keyed-in these inputs -->
    <div class="list">
	<?php 
	if(isset($_POST["submit"]))
        {
            if(!isset($_POST['inputSus']))
				$usrnm = "";
			else
				$usrnm = $_POST["inputSus"];

            $controller = new suspendAccountC();
            $message = $controller->suspend($usrnm);

            if($message["result"] == TRUE)
                displaySuccess();
            else
            {
                $fail = $message["errorMsg"];
				displayFail($fail);
            }
			
			displayUserList();
        } else
			displayUserList();
		
function displayUserList() {
	$info = new ViewAccountC();
	$list= $info->viewUsers();
	echo "<table id='table'><tr><th></th><th>User ID</th><th>Username</th><th>Name</th><th>Phone</th>";
	echo "<th>Profile</th><th>Status</th></tr>";
	for($i = 0; $i < count($list); $i++)
	{
		echo "<tr class='search_profile' contenteditable='false' value='0'>";
		echo "<td><input type='radio' name='inputSus' value='" . $list[$i]["usrnm"] ."'></td>";
		echo "<td>" . $list[$i]["id"] . "</td>";
		echo "<td>" . $list[$i]["usrnm"] . "</td>";
		echo "<td>" . $list[$i]["name"] . "</td>";
		echo "<td>" . $list[$i]["phone"] . "</td>";
		echo "<td>" . $list[$i]["profile"] . "</td>";
		echo "<td>" . $list[$i]["status"] . "</td></tr>";
	}
	echo "</table>";
}

function displaySuccess() {
	echo '<script> alert("Account has been successfully suspended"); </script>';
}

function displayFail($fail) {
	echo '<script> alert("' . $fail . '"); </script>';
}
	?>
	<br><br>
	<input type="submit" name="submit" id="deleteU" value="Suspend">
</form>
</body> 