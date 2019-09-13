function startup() {

    register = document.getElementById('register');

    register.addEventListener('click', function () {
        window.location = "/html_src/register.php";
    }, false);

}

window.addEventListener('load', startup, false);