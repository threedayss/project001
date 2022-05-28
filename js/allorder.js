var y = 0;

function served(thisID) {
    var header = document.getElementById(thisID);
    var x = header.parentElement.parentElement.querySelectorAll(".profile");
    var status = header.parentElement.parentElement.querySelector('h2');

//to change serve to green
    header.parentElement.querySelector('h3').innerHTML = "Served";
    header.parentElement.style.backgroundColor = 'lightgreen';
    header.disabled = true;
    y++;
    console.log(y);

// to change header to completed
    if (y == x.length){
        status.innerHTML = "Completed";
        status.style.color = 'red';
        status.style.borderBottom = '1px solid red';
        y = 0;
        console.log(y);
    }
    else {}
}

function removeAll(thisID) {
    var container = document.getElementById(thisID);
    var elements = container.getElementsByClassName("profile");
    var header = document.getElementById(thisID);
    var status = header.querySelector('h2');
    
    if(container.querySelector('h2').innerHTML == "Completed") {
        while (elements[0]) {
            elements[0].parentNode.removeChild(elements[0]);
        }
        status.style.color = 'black';
        status.style.borderBottom = '1px solid black';
        status.innerHTML = "No Order";
    }
}

function remove(event) {
    var x = event.target.parentElement;
    x.remove();
}


var quantity = 1;

function increase(event){
    var x = event.target.parentElement;
    var count = x.getElementsByClassName('count');
    var help = parseInt(count[0].innerHTML,10) + 1;
    count[0].innerHTML = help;
}

function decrease(event){
    var x = event.target.parentElement;
    var count = x.getElementsByClassName('count');
    var help = parseInt(count[0].innerHTML,10) - 1;
    if (help <= 0){
        x.parentElement.remove();
    }
    else {
        count[0].innerHTML = help;
    }
    
}