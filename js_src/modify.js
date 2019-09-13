function startup() {

    username_button = document.getElementById('username_button');
    email_button = document.getElementById('email_button');
    password_button = document.getElementById('password_button');
    delete_button = document.getElementById('delete_button');
    notify_select = document.getElementById('notification');

    username_button.addEventListener('click', f_username, false);
    email_button.addEventListener('click', f_email, false);
    password_button.addEventListener('click', f_password, false);
    delete_button.addEventListener('click', f_delete, false);
    notify_select.addEventListener('change', f_notify, false);

}

function f_username(ev) {

    new_username = ev.composedPath()[2][0].value;

    if ( ! new_username )
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
                div = document.getElementById("div_username");
                message = document.createTextNode("Username succesfully changed");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'success');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            if (msg === "") {
                div = document.getElementById("div_username");
                message = document.createTextNode("Username is already taken");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/modify_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("new_username="+new_username);

    ev.composedPath()[2][0].value = "";
    ev.preventDefault();

}

function f_email(ev) {

    new_email = ev.composedPath()[2][0].value;

    if ( ! new_email )
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
                div = document.getElementById("div_email");
                message = document.createTextNode("Email succesfully changed");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'success');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            if (msg === "") {
                div = document.getElementById("div_email");
                message = document.createTextNode("Email is already taken");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/modify_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("new_email="+new_email);

    ev.composedPath()[2][0].value = "";
    ev.preventDefault();

}

function f_password(ev) {


    old_passwd = encodeURIComponent(ev.composedPath()[2][0].value);
    new_passwd = encodeURIComponent(ev.composedPath()[2][1].value);
    repeat_passwd = encodeURIComponent(ev.composedPath()[2][2].value);


    if ( ! old_passwd || ! new_passwd || ! repeat_passwd)
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
                div = document.getElementById("div_reenter");
                message = document.createTextNode("Password succesfully changed");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'success');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            else {
                div = document.getElementById("div_reenter");

                if (msg === "1")
                    message = document.createTextNode("Old password is incorrect");
                else if (msg === "2")
                    message = document.createTextNode("Passwords don't match");
                else if (msg === "3")
                    message = document.createTextNode("New password is not secure");
                else
                    message = document.createTextNode("Unknown error");

                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/modify_back.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("old_passwd="+old_passwd+"&new_passwd="+new_passwd+"&repeat_passwd="+repeat_passwd);

    ev.composedPath()[2][0].value = "";
    ev.composedPath()[2][1].value = "";
    ev.composedPath()[2][2].value = "";
    ev.preventDefault();

}

function f_delete(ev) {

    passwd = ev.composedPath()[2][0].value;

    if ( ! passwd )
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
                window.location = "/index.php?status=deleted";
            }
            else {
                div = document.getElementById("div_delete");
                message = document.createTextNode("Password is incorrect");
                paragraph = document.createElement("p");
                paragraph.setAttribute('id', 'error');
                paragraph.appendChild(message);
                div.appendChild(paragraph);
            }
            
        }
    }
    xhttp.open("POST", "/php_src/delete_account.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("passwd="+passwd);

    ev.composedPath()[2][0].value = "";

    ev.preventDefault();
}

function f_notify(ev) {

    en_dis = parseInt(ev.composedPath()[0].selectedIndex);

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/php_src/change_notification.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("en_dis="+en_dis);

    ev.preventDefault();
}

window.addEventListener('load', startup, false);