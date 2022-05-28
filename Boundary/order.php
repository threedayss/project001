<?php
    session_start();
    require("../Controller/browseMenuC.php");
    require("../Controller/AddToCart.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/cart.js"></script>
<script type="text/javascript" src="../js/order.js"></script>


<link rel="stylesheet" href="../css/restauranthome.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/order.css">
<link rel="stylesheet" href="../css/sidebar.css">

<body>
<!-- for the heading of the website -->
    <div class="header">
        <span class="username">
            <div id="view-cart">
                <a href="cart.php">View Cart</a>
            </div>
        </span>
    </div>


    <body>
    
        <div class="wrapper">
<!--Top menu -->
            <div class="sidebar">
                <div class="category">
                <?php
                    echo "<p>Table ". $_SESSION["table_num"] ."</p>";
                    echo "</div>";
                    echo "<ul>";
					
					displayMenuList();
					
					function displayMenuList() {
						$controller = new BrowseMenuC();
						$menulist = $controller->browseMenu();
						$categories = array();

						foreach($menulist as $menu)
							array_push($categories, $menu["category"]);
						
						$categories = array_unique($categories);
						sort($categories);

						foreach($categories as $category)
						{
							echo "<li>";
							echo "<a href=\"#$category\">";
							echo "<span class=\"item\">$category</span>";
							echo "</a>";
							echo "</li>";
						}

						echo "</ul>";
						echo "</div>";
						echo "</div>";
						echo "<div class=\"board\">";

						foreach($categories as $category)
						{
							echo "<div id=\"$category\" class=\"food\">";
							echo "<h2>$category</h2>";

							for($i = 0; $i < count($menulist); $i++)
							{
								if($menulist[$i]["category"] == $category)
								{
									$_SESSION["q" . $menulist[$i]["id"]] = 1;

									echo "<div href='#' class=\"profile\">";
									echo "<img src=\"../pictures/" . $menulist[$i]["pict"] ."\">";
									echo "<h3>". $menulist[$i]["name"] ."</h3>";
									echo "<p>$". $menulist[$i]["price"] ."</p>";
									echo "<p class=\"desc\">". $menulist[$i]["description"] ."</p>";
									// echo "<div class=\"counter\">";
									// echo "<a href='order.php?Min=". $menulist[$i]["id"] ."'><div class=\"btn\">-</div></a>";
									// echo "<div class=\"count\">". $_SESSION["q" . (string)$menulist[$i]["id"]] ."</div>";
									// echo "<a href='order.php?Add=". $menulist[$i]["id"] ."'><div class=\"btn\">+</div></a>";
									// echo "</div>";
									echo "<a href='order.php?ItemToAdd=". $menulist[$i]["id"] ."&quan=". $_SESSION["q" . $menulist[$i]["id"]] ."'><button class=\"add-to-cart\">Add to Cart</button></a>";
									echo "</div>";
								}
							}
							
							echo "</div>";
						}
					}
                    
                    if(isset($_GET["ItemToAdd"]))
                    {
                        $food_id = $_GET["ItemToAdd"];
                        $quantity = 1;
                        $order_id = $_SESSION["order_id"];
                        $table_num = $_SESSION["table_num"];

                        $controller = new AddToCartC();
                        $result = $controller->addToCart($order_id, $table_num, $food_id, $quantity);

                        if($result == FALSE)
                            displayFail();
                    }

                    if(isset($_GET["Add"]))
                    {
                        $food_id = $_GET["Add"];
                        $_SESSION["q" . $_GET["Add"]] += 1;
                    }
					
					function displayFail() {
						echo '<script> alert("Cannot add item to cart. Please try again.") </script>';
					}
                ?>
            </div>
        </div>
    </div>
</body>