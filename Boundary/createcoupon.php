<?php
    require("../Controller/create-coupon-controller.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/createcoupon.js"></script>

<link rel="stylesheet" href="../css/createcoupon.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">

<body>
    <?php
        $ccb = new CreateCpnController();
        
        if(isset($_POST['submitb'])) {
            $str = $ccb->validateCouponDetails($_POST['code'], $_POST['value'], $_POST['stock'], strval($_POST['sdate']), strval($_POST['edate']), $_POST['desc']);

            switch($str) {
                case "emptyInput":      echo "<script> alert('Please fill in the necessary information'); </script>";
                                        break;
                case "createInvalid":   displayFail();
                                        break;
                case "createValid":     $ccb->createCoupon($_POST['code'], $_POST['value'], $_POST['stock'], strval($_POST['sdate']), strval($_POST['edate']), $_POST['desc']);
										displaySucess();
            }
        }

		function displaySucess() {
			echo "<script> alert('New Coupon has been issued'); </script>";
		}
		
		function displayFail() {
			echo "<script> alert('Failed to create coupon'); </script>";
		}
    ?>
<!-- for the heading of the website -->
    <div class="header">
        <a href="restauranthome.html">
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

    <!-- allow users to move around to different pages related to user profile and user accounts-->
    <div class="board">

        <!-- this para is for you guys incase yall get confused which row is for user account/ user profile -->
        <p>Coupons: </p><br>
        <a href="createcoupon.php" class="profile" id="add">
            Create Coupon
        </a>
        <a href="viewcoupon.php" class="profile">
            View Coupon
        </a>
        <a href="deletecoupon.php" class="profile">
            Suspend Coupon
        </a>
        <a href="modifycoupon.php" class="profile">
            Update Coupon
        </a>
        <br>
                
    </div>

<br>
<form method="post">
<table align='center'><tr><td>
            <label for="couponcode">Coupon Code:</label>
            <input name="code" type="text" id="couponcode">
            <br><br>

            <label for="coupondiscount">Coupon Discount:</label>
            <input name="value" type="text" id="coupondiscount">
            <br><br>
			
			<label for="couponstock">Coupon Stock:</label>
            <input name="stock" type="text" id="couponvalue">
            <br><br>

            <label for="couponstart">Coupon Start:</label>
            <input name="sdate" type="date" id="couponstart">
            <br><br>

            <label for="couponend">Coupon End:</label>
            <input name="edate" type="date" id="couponend">
            <br><br>
        
		<span id="descriptionspan">
            <label for="coupondesc">Coupon Description:</label>
            <input name="desc" type="text" id="coupondesc">
        </span>
        <br>
    </span>
    <button name="submitb" id="createbutton">
        Create New Coupon
    </button> 
	</td></tr></table>
</form>
</body>