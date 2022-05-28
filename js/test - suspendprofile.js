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

// to make sure the search result is one of the database infor
 function searchValidate() {
    var input, filter, a, i;
    input = document.getElementById("myInput").value;
    filter = input.toUpperCase();
    div = document.getElementById("searchbar");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].innerText;
        if (txtValue.toUpperCase.indexOf(filter) == filter) {
          input.value = txtValue;
        } else {
          input.value = "";
        }
      }
 }
 
