

function getRoomValue(str) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Assuming the response text includes bed options and rent value
            var response = this.responseText.split('||');
            document.getElementById('bedNumber').innerHTML = response[0];
            document.getElementById('monthlyRent').value = response[1].trim(); // Trim any extra whitespace
        }
    }

    xmlhttp.open("GET", "../includes/fetch_beds.php?value=" + str, true);
    xmlhttp.send();
}


