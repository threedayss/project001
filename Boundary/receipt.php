<?php
    session_start();
    require("../Controller/viewOrderHistoryC.php");
?>
<!DOCTYPE html>

<script type="text/javascript" src="../js/topbar.js"></script>

<link rel="stylesheet" href="../css/receipt.css">

<body>
<!-- items in checkout -->
    <div class="header">
        <h3 id="heading">Payment Successful</h3>
    </div>

<?php
    function displaySubmittedOrder($order_id, $table_num)
    {
        $items = 0;
        $subtotal = 0;

        $controller = new ViewOrderHistoryC();
        $bill = $controller->getSubmittedOrder($order_id, $table_num);
    
        echo "<h2> Receipt Date: " . $bill[0]["date"] . "</h2>";

        for($i = 0; $i < count($bill); $i++)
        {
            $amount = (float)$bill[$i]["quantity"]* (float)$bill[$i]["price"];
            $items += (int)$bill[$i]["quantity"];
    
            echo "<div class=\"cart-items\">";
            echo "<div class=\"item-image\">";
            echo "<img src=\"../pictures/". $bill[$i]["picture"] ."\"/>";
            echo "</div>";
            echo "<div class=\"about\">";
            echo "<h1 class=\"title\">". $bill[$i]["name"] ."</h1>";
            echo "<h3 class=\"subtitle\">". $bill[$i]["description"] ."</h3>";
            echo "</div>";
            echo "<div class=\"prices\">";
            echo "<div class=\"amount\">$" . $amount . "</div>";
            echo "</div>";
            echo "</div>";
        }

        ?>
            <hr> <br>
                <div class="checkout">
                    <div class="total">
                        <div>
                            <div class="Subtotal">Sub-Total</div>
                            <div class="items"><?php echo $items; ?> items</div>
                        </div>
                        <div class="total-amount">$<?php echo (float)$bill[0]["total"]; ?></div>
                    </div>
                    </br>
                </div>

            <form action="receipt.php" method="POST">
                <button class="button" name="back">Create Another Order</button>
            </form>
        <?php
    }

    $order_id = $_SESSION["order_id"];
    $table_num = $_SESSION["table_num"];

    displaySubmittedOrder($order_id, $table_num);

    if(isset($_POST["back"]))
    {
        session_destroy();
        header("Location: ../Boundary/createorder.php");
    }
?>  
</body>
</html>