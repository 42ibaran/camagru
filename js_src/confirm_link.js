function confirm() {

    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }

    var username = $_GET['username'] || "";
    var code = $_GET['code'] || "";

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;

            if (msg === "OK") {
                window.location = "/html_src/timeline.php";
            }
            else {
                window.location = "/index.php?status=old_link";
            }

        }
    }
    xhttp.open("POST", "/php_src/confirm_link_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("code="+code+"&username="+username);

}

window.addEventListener('load', confirm, false);