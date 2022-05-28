<?php 
require('../Controller/searchMenuC.php');
require ('../Controller/viewMenuC.php'); ?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/searchbar.js"></script>
<script type="text/javascript" src="../js/viewmenu.js"></script>

<link rel="stylesheet" href="../css/viewmenu.css">
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
                  <button onclick='displayAlert()';>Logout</button>
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
        <a href="viewmenu.php" class="profile" id="add">
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

<!-- search bar with dropdown function -->
<!-- dropdown content will be menu items -->
<div class="drop">
	<form method='post'>
    <input type="text" placeholder="Search..." id="myInput" name="myInput" onclick="showFunction()">
	<input type="submit" name="submit" id="searchM" value="Search">
	</form>
</div>
	<?php 
	if(isset($_POST['submit']))
		displayMenuInfo();
	else
		displayAllMenus();
	
	function displayMenuInfo() {
		$controller = new SearchMenuC();
        $info = $controller->checkKeyword($_POST['myInput']);
		if($info != NULL) {
			echo "<table border='1' align='center'><tr><th>Category</th><th>Food ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Image</th>";
			for($i = 0; $i < count($info); $i++)
			{
				echo "<tr><td>" . $info[$i]["category"] . "</td>";
				echo "<td>" . $info[$i]["id"] . "</td>";
				echo "<td>" . $info[$i]["name"] . "</td>";
				echo "<td>" . $info[$i]["description"] . "</td>";
				echo "<td>" . $info[$i]["price"] . "</td>";
				echo "<td>" . $info[$i]["stock"] . "</td>";
				echo "<td><img src='../pictures/" . $info[$i]["picture"] ."' alt='No image' height='200' width='200'></td>";
			}
			echo "</table>";
		} else {
			displayNotFound();
		}
	}
	
	function displayNotFound() {
		echo "No record found";
	}
	
	function displayAllMenus() {
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
			echo "<td><img src='../pictures/" . $menulist[$i]["picture"] ."' alt='No image' height='200' width='200'></td>";
		}
		echo "</tr></table>";
	}
	?>
	</div>
</body> 