<?php 
require('../Controller/deleteMenuC.php');
require('../Controller/viewMenuC.php');
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/suspendmenu.js"></script>

<link rel="stylesheet" href="../css/suspendmenu.css">
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
                  <button onclick="displayAlert()";>Logout</button>
                </div>
              </div>
        </span> 
    </div>

<!-- allow users to move around to different pages related to menu item -->
    <div class="board">
        <span>Menu Item</span><br><br>
        <a href="createmenu.php" class="profile">
            Create Menu Item
        </a>
        <a href="viewmenu.php" class="profile">
            View Menu Item
        </a>
        <a href="suspendmenu.php" class="profile" id="add">
            Suspend Menu Item
        </a>
        <a href="modifymenu.php" class="profile">
            Update Menu Item
        </a>
        <br>
    </div>

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
    <input type="text" placeholder="Search..." id="myInput" onclick="showFunction()" onkeyup="filterFunction()">
	<br><br>
<form action='suspendMenu.php' method='post'>
</div>
<!-- once user clicks on a menu item from searchbar's dropdown,
    details will be auto keyed-in these inputs -->
    <div class="list">
	<?php 
	if(isset($_POST["submit"]))
        {
            $food_id = $_POST["input"];

            $controller = new DeleteMenuC();
            $message = $controller->deleteItem($food_id);

            if($message["result"] == TRUE)
                displaySuccess();
            else
            {
                $fail = $message['errorMsg'];
				displayFail($fail);
            }
			
			displayAllMenus();
        } else
			displayAllMenus();
		
function displayAllMenus() {
	$list = new ViewMenuC();
	$menulist= $list->viewMenu();
	echo "<table id='table'><tr><th></th><th>Category</th><th>Food ID</th><th>Name</th><th>Stock</th><th>Description</th><th>Price</th><th>Image</th>";
	for($i = 0; $i < count($menulist); $i++)
	{
		echo "<tr class='search_profile' contenteditable='false' value='0'>";
		echo "<td><input type='radio' name='input' value='" . $menulist[$i]["id"] ."'></td>";
		echo "<td>" . $menulist[$i]["category"] . "</td>";
		echo "<td>" . $menulist[$i]["id"] . "</td>";
		echo "<td>" . $menulist[$i]["name"] . "</td>";
		echo "<td>" . $menulist[$i]["stock"] . "</td>";		
		echo "<td>" . $menulist[$i]["description"] . "</td>";
		echo "<td>" . $menulist[$i]["price"] . "</td>";
		echo "<td>" . $menulist[$i]["picture"] . "</td>";
	}
	echo "</tr></table>";
}

function displaySuccess() {
	echo '<script> alert("Menu has been successfully removed") </script>';
}

function displayFail($fail) {
	echo '<script> alert("' . $fail . '"); </script>';
}
	?>
	<br><br>
	<input type="submit" name="submit" id="deleteM" value="Delete">
</form>
</body> 