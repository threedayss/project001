<?php
    require("../Controller/createMenuC.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/createmenu.js"></script>

<link rel="stylesheet" href="../css/createmenu.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">

<body>
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
                <p>Menu: </p><br>
                <a href="createmenu.php" class="profile" id="add">
                    Create Menu Item
                </a>
                <a href="viewmenu.php" class="profile">
                    View Menu Item
                </a>
                <a href="suspendmenu.php" class="profile">
                    Suspend Menu Item
                </a>
                <a href="modifymenu.php" class="profile">
                    Update Menu Item
                </a>
                <br>
                
    </div>

<br>
    
        <span class="options">
            <form action="createmenu.php" method="POST">
            <label for="itemcategory">Item Category:</label>
            <input type="text" id="itemcategory" name="food_cat" >
            <br><br>

            <label for="itemname">Item Name:</label>
            <input type="text" name="food_name" id="itemname">
            <br><br>

            <label for="itemimage">Item Image:</label>
            <input type="file" name="images_URL" id="itemimage">
            <br><br>

            <label for="itemprice">Item Price:</label>
            <input type="text"  name="price_per_unit" id="itemprice" onfocusout="validatePrice()">
            <span id="priceerror" class="error"></span>
            <br><br>

            <label for="itemprice">Stocks:</label>
            <input type="text"  name="stock" id="itemprice" onfocusout="validatePrice()">
            <span id="priceerror" class="error"></span>
            <br><br>


        <span id="descriptionspan">
            <label for="itemdescription">Item Description:</label>
            <input type="text" name="food_desc" id="itemdescription">
        </span>
        <br>
    </span>
    <input type="submit" name="create" value="Create New Item">  
    </form>     

<?php
    if(isset($_POST["create"]))
    {
        $food_name = stripslashes($_POST["food_name"]);
        $food_cat = stripslashes($_POST["food_cat"]);
        $food_desc = $_POST["food_desc"];
        $images_URL = $_POST["images_URL"];
        $price_per_unit = $_POST["price_per_unit"];
        $stock = $_POST["stock"];

        $controller = new CreateMenuC();
        $result = $controller->validateMenuDetails($food_cat, $food_name, $food_desc, $stock, $price_per_unit, $images_URL);

        if($result["result"] == FALSE) {
            $fail = $result["errorMsg"];
			displayFail($fail);
		} else
			displaySuccess();
    }
	
	function displaySuccess() {
		echo '<script> alert("New menu item has been added"); </script>';
	}
	
	function displayFail($fail) {
		echo '<script> alert("' . $fail . '"); </script>';
	}
?>
</body>
</html>