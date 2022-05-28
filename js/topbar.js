// for users to logout -> there will be a popout for user to confirm they
// want to logout
function displayAlert() {
    var ok = confirm("Do you want to logout?");
    if(ok){
        displayPage();
    }
    else{
        // else nothing happens
    }
}

function displayPage() {
	window.location.href=("../Boundary/LoginB.php");
}