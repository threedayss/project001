// everytime user clicks enter button, the name will be added to "selected"
// refer to suspendprofile.html
function addName() {
    var input = document.getElementById("myInput").value;
    var para = document.createElement("p");
    var node = document.createTextNode(input);
    para.appendChild(node);
    document.getElementById("selected").appendChild(para);
}   

// when user click on undo button, the last added name in "selected" will be
// removed
function removeFunction() {
    var help = document.getElementById("selected").lastElementChild;
    help.remove();
}