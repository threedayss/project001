<?php
    require("../Controller/createAccountC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/createuser.js"></script>
<link rel="stylesheet" href="../css/createuser.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">

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
        <a href="createaccount.php" class="profile" id="add">
            Add User
        </a>
        <a href="viewaccount.php" class="profile">
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
    
<!-- user will key in new profile's details into these inputs -->
<form action="createaccount.php" method="POST">
    <div class="profile">
        <span class="options">
            <label for="username">Username:</label>
            <input type="text" id="username" name="usrnm">
            <br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" onfocusout="validatePassword()" name="pswd">
            <span id="passwordError"></span>
            <br><br>

            <label for="repassword">Re-type Password:</label>
            <input type="password" id="repassword" onfocusout="validateRePassword()">
            <span id="repasswordError"></span>
            <br><br>

            <label for="name">Account Name:</label>
            <input type="text" id="name" name="name">
            <br><br>
			
			 <label for="number">Phone Number:</label>
			<input type="text" id="number" name="phone" onfocusout="validateNumber()">
			<span id="numberError"></span>
			<br><br>
			<label for="profilename" id="profileimg">User Profile:</label>
			<select name="profile" id="profilename">
				<option value="User Admin">User Admin</option>
				<option value="Manager">Restaurant Manager</option>
				<option value="Staff">Restaurant Staff</option>
				<option value="Owner">Restaurant Owner</option>
			</select>
			<br><br><br>
			
            <input type="submit" name="create" value="Create Account">
        </span>
        <br>
    </div>
</form>
</body>
    <?php
        if(isset($_POST['create']))
        {
            $usrnm = stripslashes($_POST["usrnm"]);
			$phone = $_POST["phone"];
			$profile = $_POST["profile"];
			$pswd = md5($_POST["pswd"]);
			$name = stripslashes($_POST["name"]);
            
            $controller = new createAccountC();
            $result = $controller->validateDetails($usrnm, $pswd, $phone, $profile, $name);
            
            if($result["result"] == TRUE)
                displaySuccess();
            else {
				$fail = $result["errorMsg"];
				displayFail($fail);
			}
        }
		
	function displaySuccess() {
		echo '<script> alert("New user account has been successfully created."); </script>';
	}

	function displayFail($fail) {
		echo '<script> alert("' . $fail . '"); </script>';
	}
    ?>
</html>