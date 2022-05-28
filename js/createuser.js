// validation for phone number -> make sure number is 8 numbers
function validateNumber(){
    var phone = document.getElementById("number").value;
    var phoneregex = new RegExp("^[0-9]{8}$");
    var result = true;
    var span = document.getElementById("numberError");

    if(!phoneregex.test(phone)) {
        span.style.display ="block";
        document.getElementById("numberError").style.color ="red";
        document.getElementById("numberError").innerHTML = "Not a number"
        result = false;
    }
    else {
        span.style.display = 'none';
    }
    return result;
}

// validation for password -> make sure password lenght is 6-16, has 1 capital letter & 1 special character
function validatePassword() {
    var password = document.getElementById("password").value;
    var passwordregex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
    var result = true;
    var span=document.getElementById("passwordError");

    if(!passwordregex.test(password)){
        span.style.display ="block";
        document.getElementById("passwordError").style.color ="red";
        document.getElementById("passwordError").innerHTML = "Please include 1 capital letter, 1 number and 1 special character"
        result = false;
    }

    else {
       span.style.display = 'none';
    }
    return result;
}

// validation for repassword -> make sure password & repassword is the same
function validateRePassword(){
    var password = document.getElementById("password").value;
    var repassword = document.getElementById("repassword").value;
    var span = document.getElementById("repasswordError");
    var result = true;

    if(password === repassword){
        span.style.display = 'none';
    }

    else {
        span.style.display = "block";
        document.getElementById("repasswordError").style.color ="red";
        document.getElementById("repasswordError").innerHTML = "Password does not match"
        result = false;
    }

    return result;
}

function displaySuccess() {
	alert("New user account has been successfully created.");
}

function displayFail() {
	alert("Username and Phone already exist. Please enter again.");
}