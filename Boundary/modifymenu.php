<?php
    require("../Controller/modifyMenuC.php");
	require("../Controller/viewMenuC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/updatemenu.js"></script>

<link rel="stylesheet" href="../css/updatemenu.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/board.css">
<link rel="stylesheet" href="../css/searchbar.css">


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

<!-- allow users to move around to different pages related to user profile -->
	<div class="board">
        <span>Menu Item</span><br><br>
        <a href="createmenu.php" class="profile">
            Create Menu Item
        </a>
        <a href="viewmenu.php" class="profile">
            View Menu Item
        </a>
        <a href="suspendmenu.php" class="profile">
            Suspend Menu Item
        </a>
        <a href="modifymenu.php" class="profile" id="add">
            Update Menu Item
        </a>
        <br>
    </div>

<!-- user will key in new profile's details into these inputs -->
<form action="modifymenu.php" method="POST">
<div class="profile">
    <span class="options">
        <label for="id">Item ID:</label>
        <input type="text" id="id" name="id">
		<br><br>

        <label for="name">Item Name:</label>
        <input type="text" id="name" name="name">
        <br><br>
		<label for="category">Item Category:</label>
        <input type="text" id="category" name="category">
		<br><br>
		<label for="price">Item Price: $</label>
		<input type="text" id="price" name="price" pattern="[0-9]+">
		<br><br>
		<label for="stock">Stocks:</label>
        <input type="text" id="stock" name="stock" pattern="[0-9]+">
		<br><br>
		<label for="picture">Item Image:</label>
        <input type="file" id="image" name="image">
		<br><br>
		<span id="descriptionspan">
            <label for="itemdescription">Item Description:</label>
            <input type="text" name="desc" id="desc">
        </span>
		<br><br>
            
        <input type="submit" name="submit" id="modify" value="Modify"> 
    </span>
    <br><br>
</div>
</form>
<?php
function displayMenuList() {
	$list = new ViewMenuC();
	$menulist= $list->viewMenu();
	echo "<table border='1' align='center'><tr><th>Category</th><th>Food ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Image</th>";
	for($i = 0; $i < count($menulist); $i++)
	{
		echo "<tr class='search_profile' contenteditable='false' value='0'>";
		echo "<td>" . $menulist[$i]["category"] . "</td>";
		echo "<td>" . $menulist[$i]["id"] . "</td>";
		echo "<td>" . $menulist[$i]["name"] . "</td>";
		echo "<td>" . $menulist[$i]["description"] . "</td>";
		echo "<td>" . $menulist[$i]["price"] . "</td>";
		echo "<td>" . $menulist[$i]["stock"] . "</td>";
		echo "<td>" . $menulist[$i]["picture"] . "</td>";
	}
	echo "</tr></table>";
}
        if(isset($_POST["submit"]))
        {
            $food_id = $_POST["id"];

            if(isset($_POST["name"]))
			    $food_name = $_POST['name'];
            else
                $food_name = NULL;
            
            if(isset($_POST["category"]))
                $food_cat = $_POST['category'];
            else
                $food_cat = NULL;
			
			if(isset($_POST["price"]))
                $price_per_unit = $_POST['price'];
            else
                $price_per_unit = NULL;
			
			if(isset($_POST["stock"]))
                $stock = $_POST['stock'];
            else
                $stock = NULL;
			
			if(isset($_POST["image"]))
                $images_URL = $_POST['image'];
            else
                $images_URL = NULL;
			
			if(isset($_POST["desc"]))
                $food_desc = $_POST['desc'];
            else
                $food_desc = NULL;

            $controller = new modifyMenuC();
            $message = $controller->validateDetails($food_id, $food_name, $food_cat, $food_desc, $price_per_unit, $stock, $images_URL);

            if($message == TRUE) 
                displaySuccess();
            else
				displayFail();
			
			displayMenuList();
        }
		
function displaySuccess() {
	echo '<script> alert("Item has been updated"); </script>';
}

function displayFail() {
	echo '<script> alert("Modification failed."); </script>';
}
    ?>
</body>
</html>