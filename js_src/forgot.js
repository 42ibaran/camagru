function startup() {

    send = document.getElementById('send');

    send.addEventListener('click', f_send, false);

}

function f_send(ev) {

    email_username = event.composedPath()[2][0].value;

    if ( ! email_username )
        return ;

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;

            previous_err = document.getElementById("error");
            if (previous_err)
                previous_err.parentElement.removeChild(previous_err);
            previous_succ = document.getElementById("success");
            if (previous_succ)
                previous_succ.parentElement.removeChild(previous_succ);

            if (msg === "OK") {
                window.location = "/index.php?status=password_sent";
            }
            if (msg === "KO") {
                div = document.getElementById("window");
                message = document.createTextNode("No such email or username");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/forgot_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email_username="+email_username);

    event.composedPath()[2][0].value = "";
    ev.preventDefault();

}

window.addEventListener('load', startup, false);