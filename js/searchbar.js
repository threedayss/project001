// when user click on searchbar, the dropdown content will show
// dropdown content is linked to php, it shows all users/profile available
function showFunction() {
    var div, a;
    document.getElementById("searchbar").classList.toggle("show");
}

// when user type something in the searchbar, any search result that has
// similar spelling to user's input will show
function filterFunction() {
  let input = document.getElementById('myInput').value;
  input=input.toLowerCase();
  let x = document.getElementsByClassName('search_profile');
  let y = document.getElementsByClassName('drop-content');
  let li = document.getElementsByClassName('hello');
    
  for (i = 0; i < x.length; i++) { 
        //a = li[i].getElementsByTagName("a")[0];
      if (!x[i].innerHTML.toLowerCase().includes(input)) {
          x[i].style.display="none";
          x[i].value = 0;
      }
      else {
          x[i].style.display="";
          x[i].value = 1;               
      }
  }

  for (i = 0; i < li.length; i++) { 
    //a = li[i].getElementsByTagName("a")[0];
  if (!li[i].innerHTML.toLowerCase().includes(input)) {
      li[i].style.display = "none";

  }
  else {
      li[i].style.display = "";
              
  }
}
}

// when user click on one of the searchbar result, the searchbar will be inputted with
// the searchbar result they clicked on
function inputFunction(thisID) {
  var input = document.getElementById("myInput");
  input.value = document.getElementById(thisID).innerHTML;
}
