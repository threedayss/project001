// when user click on enter button, the searchbar result will be input into
// the "name" row.
function addName() {
    var input = document.getElementById("myInput").value;
    document.getElementById("name").value = input;
}  

function displaySuccess() {
	alert("Profile has been updated");
}

function displayFail() {
	alert("Profile is not registered");
}