<?php
    require("../Controller/updateAccountC.php");
	require("../Controller/viewAccountC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/updateuser.js"></script>

<link rel="stylesheet" href="../css/updateuser.css">
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
        <a href="suspendaccount.php" class="profile">
            Suspend User
        </a>
        <a href="updateaccount.php" class="profile" id="add">
            Update User
        </a>
        <br>
    </div>

<!-- user will key in new profile's details into these inputs -->
<form action="updateaccount.php" method="POST">
<div class="profile">
    <span class="options">
        <label for="usrnm">Username:</label>
        <input type="text" id="usrnm" name="usrnm">
		<br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="pswd" pattern="(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}">
        <br><br>
		<label for="name">Name:</label>
        <input type="text" id="name" name="name">
		<br><br>
		<label for="phone">Phone:</label>
		<input type="text" id="phone" name="phone" pattern="[0-9]{8}">
		<br><br>
		<label for="profile">Profile:</label>
        <input type="text" id="profile" name="profile">
		<br><br>
		<label for="status">Status:</label>
        <input type="radio" id="status" name="status" value="Active"> Active
        <input type="radio" id="status" name="status" value="Suspended"> Suspended
        <br><br>
            
        <input type="submit" name="submit" id="update" value="Update"> 
    </span>
    <br><br>
</div>
</form>
<?php
function displayUserList() {
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
        if(isset($_POST["submit"]))
        {
            $usrnm = $_POST["usrnm"];

            if(isset($_POST["pswd"]))
			    $pswd = md5($_POST['pswd']);
            else
                $pswd = NULL;
            
            if(isset($_POST["name"]))
                $name = $_POST['name'];
            else
                $name = NULL;
			
			if(isset($_POST["phone"]))
                $phone = $_POST['phone'];
            else
                $phone = NULL;
			
			if(isset($_POST["profile"]))
                $profile = $_POST['profile'];
            else
                $profile = NULL;
			
			if(isset($_POST["status"]))
                $status = $_POST['status'];
            else
                $status = NULL;

            $controller = new updateAccountC();
            $message = $controller->validateDetails($usrnm, $pswd, $phone, $name, $profile, $status);

            if($message == TRUE) 
                displaySuccess();
            else
				displayFail();
			
			displayUserList();
        }
		
function displaySuccess() {
	echo '<script> alert("Account has been updated"); </script>';
}

function displayFail() {
	echo '<script> alert("Update failed."); </script>';
}
    ?>
</body>
</html>