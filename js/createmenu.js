function validatePrice() {
    var price = document.getElementById('itemprice').value;
    var priceregex = new RegExp("^[0-9]*\.[0-9]{0,2}$");
    var result = true;
    var span = document.getElementById("priceerror");

    if(!priceregex.test(price)) {
        span.style.display ="block";
        document.getElementById("priceerror").style.color ="red";
        document.getElementById("priceerror").innerHTML = "Not a valid price"
        result = false;
    }
    else {
        span.style.display = 'none';
    }
    return result;
}