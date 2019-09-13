var width = 540;
var height = 0;

var streaming = false;
var mask = null;
var file = "";

var video = null;
var canvas = null;
var photo = null;
var startbutton = null;
var upload_button = null;
var share = null;
var video_output = null;
var photo_output = null;

function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');
    upload_button = document.getElementById('upload_button');
    share = document.getElementById('share');
    video_output = document.getElementById('video_output');
    photo_output = document.getElementById('photo_output');

    photo.addEventListener('click', getClickPosition, false);
    share.addEventListener('click', sharePhoto, false);

    upload_button.addEventListener('click', uploadFile, false);

    var masks = document.getElementsByClassName("mask");
    for( var i = 0; i < masks.length; i++ ) {
        masks[i].addEventListener('click', function(ev) {

            mask = ev.target.getAttribute('src');

            to_unset = document.getElementsByClassName("mask");
            for( var j = 0; j < to_unset.length; j++ ) {
                to_unset[j].style.backgroundColor = "unset";;
            }
            ev.composedPath()[0].style.backgroundColor = "rgba(235, 221, 77, 0.4)";

        });
    }

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
        video.srcObject = stream;
        video.play();
    })
    .catch(function() {});

    video.addEventListener('canplay', function() {
        if (!streaming) {
            setHeightAndWidth();
            streaming = true;
        }
    }, false);

    startbutton.addEventListener('click', function(ev) {
        if (mask && streaming) {
            takepicture();
            video_output.style.display = 'none';
            photo_output.style.display = 'block';
        }
        ev.preventDefault();
    }, false);

    gotocamera.addEventListener('click', function() {
        photo_output.style.display = 'none';
        video_output.style.display = 'block';
    }, false);

    setHeightAndWidth();
    clearphoto();
}

function setHeightAndWidth() {
    height = video.videoHeight / (video.videoWidth/width);
    if (isNaN(height)) {
        height = (3 / 4) * width;
    }

    video.setAttribute('width', width);
    video.setAttribute('height', height);
    video_output.setAttribute('width', width);
    video_output.setAttribute('height', height);
    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);

}

function uploadFile(ev) {

    ev.preventDefault();
    gallery = document.getElementById("gallery");
    new_img = document.createElement("img");
    new_img.setAttribute('class', 'gallery_photo');
    new_img.setAttribute('id', Date.now());

    file = ev.composedPath()[1][0].files[0];
    if (!file)
        return ;
    var reader = new FileReader();
    reader.onloadend = function () {
        new_img.src = reader.result;
    }
    reader.readAsDataURL(file);

    new_img.addEventListener('click', function(ev) {
        file = "";
        video_output.style.display = 'none';
        photo_output.style.display = 'block';
        photo.src = ev.composedPath()[0].currentSrc;
        var context = canvas.getContext('2d');
        context.drawImage(ev.composedPath()[0], 0, 0, width, height);
    }, false);
    
    gallery.appendChild(new_img);
}

function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillRect(0, 0, canvas.width, canvas.height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
}

function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);
        
        var data = canvas.toDataURL('image/png');

        photo.setAttribute('src', data);
        gallery = document.getElementById("gallery");
        new_img = document.createElement("img");
        new_img.setAttribute('class', 'gallery_photo');
        new_img.setAttribute('id', Date.now());
        new_img.setAttribute('src', data);

        new_img.addEventListener('click', function(ev) {
            file = "";
            video_output.style.display = 'none';
            photo_output.style.display = 'block';
            photo.src = ev.composedPath()[0].currentSrc;
            var context = canvas.getContext('2d');
            context.drawImage(ev.composedPath()[0], 0, 0, width, height);
        }, false);

        gallery.appendChild(new_img);
    }
    else
        clearphoto();
}

function getClickPosition(ev) {
    var x = 0;
    var y = 0;
    
    file = "";
    out_width = photo.width;
    in_width = width;

    ratio = in_width / out_width;
    x = parseInt(ev.offsetX * ratio);
    y = parseInt(ev.offsetY * ratio);

    var pic = canvas.toDataURL('image/png');
    var size = document.getElementById("range").value;

    pic = encodeURIComponent(pic);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var name = this.responseText;

            if (name !== "") {
                photo.src = name;
                file = name;
            }

        }
    }
    xhttp.open("POST", "/php_src/do_pic.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("x="+x+"&y="+y+"&pic="+pic+"&size="+size+"&mask="+mask);

}

function sharePhoto() {
    var img = canvas.toDataURL('image/png');

    if (file == "" || !img)
        return;

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            window.location = "timeline.php";

        }
    }
    xhttp.open("POST", "/php_src/share.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("file="+file+"&data="+img);

}

window.addEventListener('load', startup, false);