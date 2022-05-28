<!DOCTYPE html>
<script type="text/javascript" src="../js/login.js"></script>
<script type="text/javascript" src="../js/topbar.js"></script>
<link rel="stylesheet" href="../css/LoginB.css">

<html>
<body>

<?php
require '../Controller/LoginC.php';

if (isset($_POST['submitb'])){
    $lc = new LoginController($_POST['usrnm'], md5($_POST['pswd']), $_POST['profile']);
    $vl = $lc->validateLogin();

    if($vl == 'validLogin') {
        switch($_POST['profile']) {
			case 'User Admin': 
				echo '<script> displayMenu(); </script>';
				break;
			case 'Manager':
                echo '<script> displayManagerPage(); </script>';
                break;
            case 'Owner':
                echo '<script> displayOwnerPage(); </script>';
                break;
            case 'Staff':
                echo '<script> displayStaffPage(); </script>';
                break;
		}
    }

    else if($vl == 'invalidLogin') {
		echo '<script> displayFail(); </script>';
    }

    else {
		echo '<script> alert("Empty Input!"); </script>';
    }
}
?>

<div class="split" id="left">
    <div class="centered">
        <h3>Welcome</h3>
            <form method="post">
<!-- for user to key in their account details -->
                <label for="uname">Username:</label>
                <br>
                <input type="text" id="uname" name="usrnm">
                <br><br>
                <label for="pword">Password:</label>
                <br>
                <input type="password" id="pword" name="pswd">
                <br><br>
<!-- according to the option user choose it will bring them to different sites 
e.g., if click on user admin will bring them to user admin site-->

<!-- there will also be a validation, if the account keyed-in is not entitled to the
role selected, they cannot login -->
                <label for="profile" id="profile">User Profile:</label>
                <select name="profile" id="profile">
                  <option value="User Admin">User Admin</option>
                  <option value="Manager">Restaurant Manager</option>
                  <option value="Staff">Restaurant Staff</option>
                  <option value="Owner">Owner</option>
                </select>
                <br>
<!-- button for user to login -->
                <input type="submit" value="Submit" id="submitb" name="submitb">
                <br>
            </form>
    </div>
</div>

<!-- this is for design, can be removed if yall want -->
<div class="split right" id="right">
    <div class="centered">
        
    </div>
</div>

</body>
</html>