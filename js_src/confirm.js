function startup() {

    register = document.getElementById('send');

    register.addEventListener('click', confirm, false);

}

function confirm(ev) {

    previous_err = document.getElementById("error");
    if (previous_err)
        previous_err.parentElement.removeChild(previous_err);

    if (username = document.getElementById("input_username"))
        username = username.value;
    else
        username = true;

    if (!ev.composedPath()[2][0].value || !username ) {
        return ;
    }

    ev.preventDefault();

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;
            
            if (msg === "OK") {
                window.location = "/html_src/timeline.php";
            }
            else if (msg === "KO") {
                div = document.getElementById("username");
                if (!div)
                    div = document.getElementById("code");
                message = document.createTextNode("Wrong code");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            else {
                div = document.getElementById("username");
                if (!div)
                    div = document.getElementById("code");
                message = document.createTextNode("Something is wrong. Return to registration or contact support team");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/confirm_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("code="+ev.composedPath()[2][0].value+"&username="+username);

}

window.addEventListener('load', startup, false);