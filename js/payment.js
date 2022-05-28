function validateEmail() {
    var email = document.getElementById('email').value;
    var span = document.getElementById('emailError');


    if (email == ""){
        span.style.display = 'block';
        span.style.color ="red";
        span.innerHTML = "Email cannot be empty";
    }

    else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        span.style.display = 'block';
        span.style.color ="red";
        span.innerHTML = "Invalid Email Address"
    }

    else if ((!email == "") && (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
        span.style.display = "none";
    }
}

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

function validateCard() {
    var regex = new RegExp ("^[0-9\s]{13,16}$");
    var card = document.getElementById('cardno').value;
    var span = document.getElementById('cardError');

    if (card == ""){
        span.style.display ="block";
        span.style.color ="red";
        span.innerHTML = "Cannot be empty";
    }
    else if(!regex.test(card)) {
        span.style.display ="block";
        span.style.color ="red";
        span.innerHTML = "Invalid Card";
    }

    else if ((regex.test(card)) && (!card == "")){
        span.style.display = 'none';
    }
}

function formatDate() {
    var d = new Date(),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

if (month.length < 2) 
    month = '0' + month;
if (day.length < 2) 
    day = '0' + day;

return [year, month].join('-');
}


function validateDate() {
var usertime = document.getElementById('carddate');
var span = document.getElementById('dateError');
console.log(usertime.value);
if (formatDate() < usertime.value) {
    span.style.color = 'red';
    span.style.display = 'block';
    span.innerHTML = "Not a valid date";
}
else if (usertime.value == ""){
    span.style.color = 'red';
    span.style.display = 'block';
    span.innerHTML = "Cannot be empty";
}
else if (formatDate() >= usertime.value) {
    span.style.display = 'none';
}
}

function validateAll() {
    var cardspan = document.getElementById('cardError');
    var emailspan = document.getElementById('emailError');
    var numberspan = document.getElementById('numberError');
    var datespan = document.getElementById('dateError');

    if ((numberspan.style.display=="none") && (emailspan.style.display=="none") && (cardspan.style.display=="none") && (datespan.style.display=="none")){
        window.location.href="../html/receipt.html";
    }
    else {
        validateCard();
        validateEmail();
        validateNumber();
        validateDate();
    }
}