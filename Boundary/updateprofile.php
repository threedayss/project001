<?php
    require("../Controller/updateProfileC.php");
	require("../Controller/viewProfileC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/updateprofile.js"></script>

<link rel="stylesheet" href="../css/updateprofile.css">
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
    <span>User Profiles</span><br><br>
    <a href="createprofile.php" class="profile">
        Add Profile
    </a>
    <a href="viewprofile.php" class="profile">
        View Profile
    </a>
    <a href="suspendprofile.php" class="profile">
        Suspend Profile
    </a>
    <a href="updateprofile.php" class="profile" id="add">
        Update Profile
    </a>
    <br>
</div>

<!-- user will key in new profile's details into these inputs -->
 <form action="updateprofile.php" method="POST">
<div class="profile">
<table align='center'><tr><td>
    <span class="options">
        <label for="name">Profile Name:</label>
        <input type="text" id="name" name="pname">
		<br><br>
    </span>

<!-- dk if we still want this -->
        <div id="describe">
            <label for="desciption">Description:</label>
            <input type="text" id="description" name="description">
            <br><br>
			<label for="status">Status:</label>
            <input type="radio" id="status" name="status" value="Active"> Active
            <input type="radio" id="status" name="status" value="Suspended"> Suspended

            </br></br>
            <label for="functions">Functions:</label><br>

            <label for="functions">Menu:</label>
            <input type="radio" id="status" name="menu" value="Yes"> Yes
            <input type="radio" id="status" name="menu" value="No"> No
            <br>

            <label for="functions">Orders:</label>
            <input type="radio" id="orders" name="orders" value="Yes"> Yes
            <input type="radio" id="orders" name="orders" value="No"> No
            <br>

            <label for="functions">Coupon:</label>
            <input type="radio" id="coupon" name="coupon" value="Yes"> Yes
            <input type="radio" id="coupon" name="coupon" value="No"> No
            <br>

            <label for="functions">Profile:</label>
            <input type="radio" id="profile" name="profile" value="Yes"> Yes
            <input type="radio" id="profile" name="profile" value="No"> No
            <br>

            <label for="functions">User:</label>
            <input type="radio" id="user" name="user" value="Yes"> Yes
            <input type="radio" id="user" name="user" value="No"> No
            <br>

            <label for="functions">Report:</label>
            <input type="radio" id="report" name="report" value="Yes"> Yes
            <input type="radio" id="report" name="report" value="No"> No
            <br>

            <label for="functions">Transaction:</label>
            <input type="radio" id="transaction" name="transaction" value="Yes"> Yes
            <input type="radio" id="transaction" name="transaction" value="No"> No
				<br><br>
                <input type="submit" name="submit" id="update" value="Update"> 
            </span>
        </div>
    <br>
</div>
</td></tr></table>

</form>
<?php
function displayProfileList() {
	$list = new ViewProfileC();
	$profilelist= $list->viewProfiles();
	echo "<table border='1'><tr><th>Profile</th><th>Description</th><th>Menu</th><th>Orders</th>";
	echo "<th>Coupon</th><th>Profile</th><th>User</th><th>Report</th><th>Transaction</th><th>Status</th>";
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
	echo "</tr></table>";
}
        if(isset($_POST["submit"]))
        {
            $functionName = array("menu", "orders", "coupon", "profile", "user", "report", "transaction");
            $functions = array();

            $UPName = $_POST["pname"];

            if(isset($_POST["description"]))
			    $desc = $_POST['description'];
            else
                $desc = NULL;
            
            if(isset($_POST["status"]))
                $status = $_POST['status'];
            else
                $status = NULL;

            foreach($functionName as $name)
            {
                if(isset($_POST[$name]))
                    $functions[$name] = $_POST[$name];
                else
                    $functions[$name] = NULL;
            }

            $controller = new updateProfileC();
            $message = $controller->validateDetails($UPName, $desc, $status, $functions);

            if($message == TRUE) 
                echo "<script>displaySuccess();</script>";
            else
				echo "<script>displayFail();</script>";
			
			displayProfileList();
        }
		
	function displaySuccess() {
		alert("Profile has been updated");
	}

	function displayFail() {
		alert("Profile is not registered");
	}
    ?>
</body>
</html>