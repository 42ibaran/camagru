function startup() {

    register = document.getElementById('register');

    register.addEventListener('click', f_register, false);

}

function f_register(ev) {

    var form = ev.composedPath()[2];
    var username = form[0].value;
    var password_1 = form[1].value;
    var password_2 = form[2].value;
    var address = form[3].value;

    if (!form || !username || !password_1 || !password_2 || !address) {
        return ;
    }

    ev.preventDefault();

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;
            
            previous_err = document.getElementById("error");
            if (previous_err)
                previous_err.parentElement.removeChild(previous_err);

            if (msg === "1") {
                div = document.getElementById("div_username");
                message = document.createTextNode("Username already taken");
                form[0].value = "";
            }
            else if (msg === "2") {
                div = document.getElementById("div_username");
                message = document.createTextNode("Invalid username");
                form[0].value = "";
            }
            else if (msg === "3") {
                div = document.getElementById("div_passwords");
                message = document.createTextNode("Passwords don't match");
            }
            else if (msg === "4") {
                div = document.getElementById("div_passwords");
                message = document.createTextNode("Password is not secure");
            }
            else if (msg === "5") {
                div = document.getElementById("div_address");
                message = document.createTextNode("Invalid email");
                form[3].value = "";
            }
            else if (msg === "6") {
                div = document.getElementById("div_address");
                message = document.createTextNode("Email already used");
                form[3].value = "";
            }
            else {
                return f_add_user(username, password_1, address);
            }

            paragraph = document.createElement("p");
            paragraph.setAttribute('id', 'error');
            paragraph.appendChild(message);
            div.appendChild(paragraph);

        }
    }
    xhttp.open("POST", "/php_src/check_new_user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username="+username+"&password_1="+password_1+"&password_2="+password_2+"&address="+address);

    form[1].value = "";
    form[2].value = "";

}

function f_add_user(username, password, address) {

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;

            previous_err = document.getElementById("error");
            if (previous_err)
                previous_err.parentElement.removeChild(previous_err);

            if (msg === "") {
                message = document.createTextNode("You have previously started registration process. Complete it or use other login and/or email");
            }
            else if (msg === "KO") {
                message = document.createTextNode("Email service error. Come back later");
            }
            else
                window.location = "/html_src/confirm.php";

            if (msg !== "OK") {
                div = document.getElementById("login");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }

        }
    }
    xhttp.open("POST", "/php_src/add_to_waitlist.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username="+username+"&password="+password+"&address="+address);

}

window.addEventListener('load', startup, false);