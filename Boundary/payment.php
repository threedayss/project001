<?php
    session_start();
    require("../Controller/makePaymentC.php");
?>
<!DOCTYPE html>
<link rel="stylesheet" href="../css/restauranthome.css">
<link rel="stylesheet" href="../css/payment.css">

<script type="text/javascript" src="../js/payment.js"></script>

<form action="payment.php" method="POST">
    <div class="payment">
        <div class="header">
            <h1>Please Enter your information for payment</h1>
        </div>
        <div class="info">
            <label for="email">E-Mail</label>
            <br>
            <input type="email" id="email" name="email" onfocusout="validateEmail();">
            <span class="error" id="emailError"></span>
        </div>
        <br>
        <div class="info">
            <label for="cardno">Card Number (Dashes Ommitted)</label>
            <br>
            <input id="cardno" type="tel" name="cardNum" inputmode="numeric" maxlength="16" placeholder="xxxx xxxx xxxx xxxx" onfocusout="validateCard();">
            <span class="error" id="cardError"></span>
        </div>
        <div class = "info">
            <label for="carddate">Card Expiry Date</label>
            <br>
            <input id="carddate" type="text" name="expiryMonth" placeholder="MM" size="5"> / <input id="carddate" type="text" name="expiryYear" placeholder="YYYY" size="10">
            <span class="error" id="dateError"></span>
        </div>
        <br>
        <div class="info">
            <label for="number">Phone Number</label>
            <br>
            <input type="number" id="number" name="phoneNum" onfocusout="validateNumber();">
            <span class="error" id="numberError"></span>
        </div>
        <br>
		<div class="info">
		    <label for="coupon">Coupon</label>
            <br>
            <input type="text" id="coupon" name="coupon">
        </div>
        <br>
        <div class="checkout">
            <div class="total">
                <div>
                    <div class="Subtotal">Sub-Total</div>
                    <div class="items"><?php echo $_SESSION["items"]; ?> items</div>
                </div>
                <div class="total-amount">$<?php echo $_SESSION["subtotal"]; ?></div>
            </div>
            
            <!-- <input type="submit" id="pay-button" name="pay" class="button" onclick="validateAll()"> -->
            <button name="pay" type="submit" id="pay-button" class="button" onclick="validateAll()">
                Pay Now
            </button>
        </div>
    </div>
</form>
<div class="checkout">
	<button onclick="window.location.href='cart.php'";>Back to Cart</button>
</div>
<?php
    function displayPaymentSuccess() {
        echo "<meta http-equiv=\"Refresh\" content=\"0; url='../Boundary/receipt.php'\">";
	}
	
	function displayFail($fail) {
		echo '<script> alert("' . $fail . '"); </script>';
	}

    if(isset($_POST["pay"]))
    {
        $email = $_POST["email"];
        $cardNo = $_POST["cardNum"];
        $phoneNum = $_POST["phoneNum"];
        $expiry = $_POST["expiryMonth"] . "/" . $_POST["expiryYear"];
		
		if(!empty($_POST["coupon"]))
			$coupon = $_POST['coupon'];
		else
			$coupon = "";
        $table_num = $_SESSION["table_num"];
        $order_id = $_SESSION["order_id"];

        $controller = new MakePaymentC();
        $result = $controller->validatePayment($email, $cardNo, $expiry, $order_id, $table_num, $coupon);

        if($result["result"] == TRUE)
           displayPaymentSuccess();
        else 
        {
            $fail = $result["errorMsg"];
            displayFail($fail);
        }
    }
?>
</body>
</html>