<?php
    session_start();
    require("../Controller/updateProgressC.php");
    require("../Controller/cancelOrderC.php");
    require("../Controller/viewOrderC.php");
    require("../Controller/modifyOrderC.php");
?>
<!DOCTYPE html>
<script type="text/javascript" src="../js/topbar.js"></script>
<script type="text/javascript" src="../js/cart.js"></script>

<link rel="stylesheet" href="../css/restauranthome.css">
<link rel="stylesheet" href="../css/topbar.css">
<link rel="stylesheet" href="../css/allorder.css">
<link rel="stylesheet" href="../css/sidebar.css">

<body>
<!-- for the heading of the website -->
    <div class="header">
        <span class="username">
            <div id="view-cart">
                <a href="staffhome.html">Dumbledore House</a>
            </div>
        </span>
    </div>
    <body>
    
        <div class="wrapper">
<!--Top menu -->
            <div class="sidebar">
                <div class="category">
            <?php
                function displayAllOrders()
                {
                    $controller = new ViewOrderC();
                    $orderList = $controller->viewOrders();
                    $tableNums = array();

                    if($orderList[0]["result"] == TRUE)
                    {
                        echo "<ul>";

                        foreach($orderList as $order)
                            array_push($tableNums, $order["table_num"]);

                        $tableNums = array_unique($tableNums);
                        sort($tableNums);

                        foreach($tableNums as $table)
                        {
                            echo "<li>";
                            echo "<a href=\"#$table\">";
                            echo "<span class=\"item\">Table $table</span>";
                            echo "</a>";
                            echo "</li>";
                        }

                        echo "</ul>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class=\"board\">";

                        foreach($tableNums as $table)
                        {
                            $order_id = 0;

                            for($i = 0; $i < count($orderList); $i++)
                            {
                                if($orderList[$i]["table_num"] == $table)
                                    $order_id = $orderList[$i]["order_id"];
                            }
                        
                            echo "<div id=\"$table\" class=\"food\">";
                            echo "<h1>Table $table</h1>";
                            echo "<h2 class=\"ordertop\">";
                            echo "<a style=\"text-decoration: none; color: black;\" href='allorder.php?Cancel=". $order_id ."&table=". $table ."'>";
                            echo "Remove all";
                            echo "</a></h2>";

                            for($i = 0; $i < count($orderList); $i++)
                            {   
                                if($orderList[$i]["table_num"] == $table)
                                {
                                    echo "<div class=\"profile\">";
                                    echo "<img src=\"../pictures/" . $orderList[$i]["picture"] . "\">";
                                    echo "<h4>" . $orderList[$i]["name"] . "</h4>";
                                    echo "<p class=\"desc\">" . $orderList[$i]["description"] ."</p>";
                                    echo "<h3>" . $orderList[$i]["status"] . "</h3>";

                                    if($orderList[$i]["status"] != "Served")
                                    {
                                        echo "<div class=\"counter\">";
                                        echo "<a href='allorder.php?ItemtoMin=". $orderList[$i]["food_id"] ."&id=". $orderList[$i]["order_id"] ."'><div class=\"btn\">-</div></a>";
                                        echo "<div class=\"count\">". $orderList[$i]["quantity"] ."</div>";
                                        echo "<a href='allorder.php?ItemtoAdd=". $orderList[$i]["food_id"] ."&id=". $orderList[$i]["order_id"] ."'><div class=\"btn\">+</div></a>";
                                        echo "</div>";
                                        echo "<a href='allorder.php?ItemtoServe=". $orderList[$i]["food_id"] ."&id=". $orderList[$i]["order_id"] ."'<button class=\"serve\">Served</button></a>";
                                        echo "<a href='allorder.php?ItemtoRemove=". $orderList[$i]["food_id"] ."&id=". $orderList[$i]["order_id"] ."'<button class=\"serve\">Remove</button></a>";
                                        echo "</div>";
                                    }
                                    else
                                        echo "</div>"; 
                                        
                                    $order_id = $orderList[$i]["order_id"];
                                }
                            }

                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "</div>";
                        echo "<div class=\"board\">";
                        echo "<div class=\"food\">";
                        echo "<h2>There is no ongoing orders at the moment</h2>";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                }

                echo "<p>Staff ID: ". $_SESSION["staff_id"] ."</p>";
                echo "</div>";

                displayAllOrders();

                if(isset($_GET["ItemtoServe"]) && isset($_GET["id"]))
                {
                    $food_id = $_GET["ItemtoServe"];
                    $order_id = $_GET["id"];

                    $controller = new UpdateProgressC();
                    $message = $controller->updateProgress($order_id, $food_id);

                    if($message["result"] == FALSE) {
                        $fail = $message["errorMsg"];
						displayFail($fail);
					}
                    else
                        refreshSuccess();
                }

                if(isset($_GET["Cancel"]) && isset($_GET["table"]))
                {
                    $order_id= $_GET["Cancel"];
                    $table_num = $_GET["table"];

                    $controller = new CancelOrderC();
                    $message = $controller->cancelOrder($order_id, $table_num);

                    if($message["result"] == FALSE){
                        $fail = $message["errorMsg"];
						displayFail($fail);
					}
                    else
                        refreshSuccess();
                }

                if(isset($_GET["ItemtoAdd"]) && isset($_GET["id"]))
                {
                    $food_id = $_GET["ItemtoAdd"];
                    $order_id = $_GET["id"];

                    $controller = new ModifyOrderC();
                    $message = $controller->addQuantityOrder($order_id, $food_id);

                    if($message["result"] == FALSE){
                        $fail = $message["errorMsg"];
						displayFail($fail);
					}
                    else
                        refreshSuccess();
                }

                if(isset($_GET["ItemtoMin"]) && isset($_GET["id"]))
                {
                    $food_id = $_GET["ItemtoMin"];
                    $order_id = $_GET["id"];

                    $controller = new ModifyOrderC();
                    $message = $controller->minusQuantityOrder($order_id, $food_id);

                    if($message["result"] == FALSE){
                        $fail = $message["errorMsg"];
						displayFail($fail);
					}
                    else
                        refreshSuccess();
                }

                if(isset($_GET["ItemtoRemove"]) && isset($_GET["id"]))
                {
                    $food_id = $_GET["ItemtoRemove"];
                    $order_id = $_GET["id"];

                    $controller = new ModifyOrderC();
                    $message = $controller->removeItemOrder($order_id, $food_id);

                    if($message["result"] == FALSE){
                        $fail = $message["errorMsg"];
						displayFail($fail);
					}
                    else
                        refreshSuccess();
                }
				
				function displayFail($fail) {
					echo '<script> alert("' . $fail . '"); </script>';
				}
				
				function refreshSuccess() {
					echo "<meta http-equiv=\"Refresh\" content=\"0; url='../Boundary/allorder.php'\">";
				}
            ?>
    <script type="text/javascript" src="../js/allorder.js"></script>
</body>