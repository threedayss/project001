
function period() {
    var type = document.getElementById("report-type").value;
    var traffic = document.getElementById("traffic");
    var sales = document.getElementById("sales-report");
    var average = document.getElementById("average-spent");

    var period = document.getElementById('period');
    var hello = document.getElementById('hello');
    
    if(type == "traffic") {
        traffic.style.display= "block";
        sales.style.display="none";
        average.style.display="none";
        document.getElementById('t-text').innerHTML = period.value;
    }
    else if(type == "sales-report"){
        traffic.style.display= "none";
        sales.style.display="block";
        average.style.display="none";
        document.getElementById('s-text').innerHTML = period.value;
    }
    else if (type == "average-spent"){
        traffic.style.display= "none";
        sales.style.display="none";
        average.style.display="block";
        document.getElementById('a-text').innerHTML = period.value;
    }
}