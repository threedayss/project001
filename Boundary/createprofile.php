<?php
    require("../Controller/createProfileC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<link rel="stylesheet" href="../css/createprofile.css">
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
    <span>User Profiles</span><br><br>
    <a href="createprofile.php" class="profile" id="add">
        Add Profile
    </a>
    <a href="viewprofile.php" class="profile">
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
    
<!-- user will key in new profile's details into these inputs -->
<form action="createprofile.php" method="POST">
<table align='center'><tr><td>
    <div class="profile">
        <span class="options">
            <label for="name">Profile Name:</label>
            <input type="text" id="name" name="UPName" onsubmit="validateName()">
			<span id="pnameError"></span>
            <br><br>
        </span>

<!-- user will tick the functions the new profile will have access to -->
        <span class="options">
            <label for="functions">Functions:</label><br>
                <input type="checkbox" id="menu" name="menu" value="menu" checked="checked">
                <label for="menu">Menu</label><br>

                <input type="checkbox" id="orders" name="orders" value="orders">
                <label for="orders">Orders</label><br>
                
                <input type="checkbox" id="coupon" name="coupon" value="coupon">
                <label for="coupon">Coupon</label><br>

                <input type="checkbox" id="profile" name="profile" value="profile">
                <label for="profile">Profile</label><br>

                <input type="checkbox" id="user" name="user" value="user">
                <label for="user">User</label><br>

                <input type="checkbox" id="report" name="report" value="report">
                <label for="report">Report</label><br>

                <input type="checkbox" id="transaction" name="transaction" value="transaction">
                <label for="transaction">Transaction</label><br>    
        </span><br><br>

<!-- dk if we still want this -->
            <div id="describe">
                <label for="desciption">Description:</label>
                <input type="text" id="description" name="description">
                <br><br>
                <span>
                <input type="submit" name="create" value="Create Profile">
                    
                </span>
            </div>
        <br>
    </div>
</td></tr></table>
</form>
    <div>
        
    </div>
    <?php
        if(isset($_POST["create"]))
        {
            $functionName = array("menu", "orders", "coupon", "profile", "user", "report", "transaction");

            $UPName = stripslashes($_POST["UPName"]);
            $description = $_POST["description"];
            $functions = array();

            foreach($functionName as $name)
            {
                if(isset($_POST[$name]))
                    array_push($functions, $name);
                else
                    array_push($functions, NULL);
            }

            $controller = new CreateProfileC();
            $result = $controller->validateDetails($UPName, $description, $functions);
            
            if($result["result"] == TRUE)
                echo "<script>displaySuccess();</script>";
            else {
				if($result["errorMsg"] == "Cannot update functions")
					echo "<script> alert('Cannot update functions'); </script>";
				else if($result["errorMsg"] == "Cannot create")
					echo "<script>displayFail();</script>";
				else if($result["errorMsg"] == "Profile exists")
					echo "<script> alert('Profile already exist'); </script>"; 
				else
					echo "<script>displayFail();</script>";
			}
        }
		
	function displaySuccess() {
		alert("New profile has been successfully created");
	}

	function displayFail() {
		alert("Failed to create profile");
	}
    ?>
</body>
</html>