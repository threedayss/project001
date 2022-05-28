 <?php
    session_start();
    require("../Controller/addToCart.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/order.js"></script>
<script type="text/javascript" src="../js/cart.js"></script>

<link rel="stylesheet" href="../css/cart.css">

<body>
<!-- items in checkout -->
    <div class="header">
        <h3 id="heading">Shopping Cart</h3>  
    <?php
        echo "<a href='cart.php?removeall=". $_SESSION["order_id"] ."'><h5 class=\"remove\" name=\"removeall\">Remove All</h5></a>";
        echo "</div>";

        $order_id = $_SESSION["order_id"];
        $subtotal = 0;
        $items = 0;
		
			$controller = new addToCartC();
			$cartlist = $controller->getCartList($order_id);

			if($cartlist[0]["result"] == TRUE)
			{
				for($i = 0; $i < count($cartlist); $i++)
				{
					$amount = (float)$cartlist[$i]["quantity"] * (float)$cartlist[$i]["price"];
					$subtotal += $amount;
					$items += (int)$cartlist[$i]["quantity"];
		
					echo "<div class=\"cart-items\">";
					
					//Item Image
					echo "<div class=\"item-image\">";
					echo "<img src=\"../pictures/". $cartlist[$i]["picture"] . "\"/>";
					echo "</div>";
					echo"<div class=\"about\">";
		
					//Item Description
					echo "<h1 class=\"title\">". $cartlist[$i]["food_name"] ."</h1>";
					echo "<h3 class=\"subtitle\">" . $cartlist[$i]["description"] . "</h3>";
					echo "</div>";
		
					//To add or remove 
					echo "<div class=\"counter\">";
					echo "<a href= 'cart.php?ItemToAdd=" . $cartlist[$i]["food_id"] . "'><button>+</button></a>";
					echo "<div class=\"count\">". $cartlist[$i]["quantity"] ."</div>";
					echo "<a href='cart.php?ItemToMin=" . $cartlist[$i]["food_id"] . "'><button>-</button></a>";
					echo "</div>";
					echo "<div class=\"prices\">";
					echo "<div class=\"amount\">$" . $amount ."</div>";
					echo "<a href='cart.php?ItemToRemove=" . $cartlist[$i]["food_id"] . "'><button name=\"remove\">Remove</button></a>";
					echo "</div>";
					echo "</div>";
				}
			}
			else
			{
				echo "</br>";
				echo "<div class=\"cart-items\">";
				echo "<h2>No item in the cart</h2>";
				echo "</div>";
				echo "</br>";
			}

        if(isset($_GET["ItemToAdd"]))
        {
            $food_id = $_GET["ItemToAdd"];
            $result = $controller->addQuantityCart($order_id, $food_id);

            if($result["result"] == FALSE){
                $fail = $result['errorMsg'];
				displayFail($fail);
			}
            else
                refreshSuccess();
        }

        if(isset($_GET["ItemToMin"]))
        {
            $food_id = $_GET["ItemToMin"];
            $result = $controller->minusQuantityCart($order_id, $food_id);

            if($result["result"] == FALSE){
                $fail = $result['errorMsg'];
				displayFail($fail);
			}
            else
                refreshSuccess();
        }

        if(isset($_GET["ItemToRemove"]))
        {
            $food_id = $_GET["ItemToRemove"];
            $result = $controller->removeItemCart($order_id, $food_id);

            if($result["result"] == FALSE) {
                $fail = $result['errorMsg'];
				displayFail($fail);
			}
            else
                refreshSuccess();
        }

        if(isset($_GET["removeall"]))
        {
            $order_id = $_GET["removeall"];
            $result = $controller->clearCart($order_id);

            if($result["result"] == TRUE)
                refreshSuccess();
        }
          
        $_SESSION["subtotal"] = $subtotal;
        $_SESSION["items"] = $items;
		
		function refreshSuccess() {
			echo "<meta http-equiv=\"Refresh\" content=\"0; url='../Boundary/cart.php'\">";
		}
		
		function displayFail($fail) {
			echo '<script> alert("' . $fail . '"); </script>';
		}
    ?>
<!-- checkout button -->
    <hr> 
        <div class="checkout">
            <div class="total">
                <div>
                    <div class="Subtotal">Sub-Total</div>
                    <div class="items"><?php echo $items; ?> items</div>
                </div>
                <div class="total-amount">$<?php echo $subtotal; ?></div>
            </div>
            <a href="order.php"><button class="button">Continue Ordering</button></a>
            <a href="payment.php"><button class="button">Checkout</button></a>
        </div>
</body>