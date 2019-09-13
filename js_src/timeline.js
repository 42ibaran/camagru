var number_of_posts = -1;
var last_page = 0;

function startup() {

    likes = document.getElementsByClassName('like');
    forms = document.getElementsByClassName('comment_form');
    deletes = document.getElementsByClassName('delete_button');

    for( var i = 0; i < likes.length; i++ ) {
        likes[i].addEventListener('click', likePhoto, false);
        forms[i].addEventListener('submit', commentPhoto, false);
    }
    for( var i = 0; i < deletes.length; i++ ) {
        deletes[i].addEventListener('click', deletePhoto, false);
    }

    if (number_of_posts == -1) {
        number_of_posts++;
        add_articles();
    }

    window.addEventListener('scroll', add_articles, false);

}

function likePhoto(ev) {

    ev.preventDefault();

    var path = ev.composedPath();
    var id = path[1].id;

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;
            
            if (msg === "") {
                window.location = "/index.php?status=none";
                return ;
            }
            path[1].childNodes[5].innerText = 
                parseInt(path[1].childNodes[5].innerText) + parseInt(msg);

        }
    }
    xhttp.open("POST", "/php_src/like.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id);

}

function commentPhoto(ev) {

    ev.preventDefault();

    var path = ev.composedPath();
    var id = path[1].id;

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            var msg = this.responseText;
            
            if (msg === "") {
                window.location = "/index.php?status=none";
                return ;
            }
            if (msg === "KO") {
                return ;
            }
            var curr_section = path[1].childNodes[7];
            var new_comment = document.createElement("div");
            var new_comment_text = document.createTextNode(msg+": "+path[0][0].value);
            new_comment.setAttribute('class', 'comments');
            new_comment.appendChild(new_comment_text);
            curr_section.appendChild(new_comment);
            path[0][0].value = "";

        }
    }
    xhttp.open("POST", "/php_src/comment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("msg="+path[0][0].value+"&id="+id);

}

function deletePhoto(ev) {

    var path = ev.composedPath();

    var delete_id = path[2].id;
    var timeline = document.getElementById("timeline");
    var delete_article = document.getElementById(delete_id);

    timeline.removeChild(delete_article);

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", "/php_src/delete_post.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("delete_id="+delete_id);
    update_page_nbrs();

}

function add_articles() {

    var body = document.body;
    var html = document.documentElement;
    var height = Math.max( body.scrollHeight, body.offsetHeight, 
        html.clientHeight, html.scrollHeight, html.offsetHeight );

    if (height == window.innerHeight + window.scrollY) {

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                var posts = this.responseText;
                
                posts = JSON.parse(posts);
                i = 0;
                while (posts[i]) {
                    filename = "/private/posts/" + posts[i]['id'] + ".png";
                    br = document.createElement("br");

                    article = document.createElement("article");
                    article.setAttribute('class', 'post');
                    article.setAttribute('id', posts[i]['id']);
            
                    new_tag = document.createElement("div");
                    new_tag.setAttribute('class', 'author');
                    author = document.createTextNode(posts[i]['author']+"'s photo");
                    new_tag.appendChild(author);
                    article.appendChild(new_tag);

                    new_tag = document.createElement("img");
                    new_tag.setAttribute('class', 'image');
                    new_tag.setAttribute('src', filename);
                    article.appendChild(new_tag);

                    article.appendChild(br.cloneNode());
                    article.appendChild(br.cloneNode());

                    new_tag = document.createElement("button");
                    new_tag.setAttribute('class', 'like');
                    like = document.createTextNode("Like");
                    new_tag.appendChild(like);
                    article.appendChild(new_tag);

                    new_tag = document.createElement("div");
                    new_tag.setAttribute('class', 'likenbr');
                    likenbr = document.createTextNode(posts[i]['likes']);
                    new_tag.appendChild(likenbr);
                    article.appendChild(new_tag);
                    
                    article.appendChild(br.cloneNode());

                    new_tag = document.createElement("div");
                    new_tag.setAttribute('class', 'comment_section');
                    j = 0;
                    while (posts[i]['comments'][j]) {
                        for ( key in posts[i]['comments'][j]) {
                            comment = posts[i]['comments'][j][key];

                            new_comment = document.createElement("div");
                            new_comment.setAttribute('class', 'comments');
                            comment_text = document.createTextNode(key+": "+comment);
                            new_comment.appendChild(comment_text);
                            new_tag.appendChild(new_comment);
                            j++;
                        }
                    }
                    article.appendChild(new_tag);

                    article.appendChild(br.cloneNode());

                    new_tag = document.createElement("form");
                    new_tag.setAttribute('class', 'comment_form');
                    new_tag_1 = document.createElement("input");
                    new_tag_1.setAttribute('class', 'comment_msg');
                    new_tag_1.setAttribute('type', 'text');
                    new_tag_1.setAttribute('required', 'true');
                    new_tag.appendChild(new_tag_1);
                    new_tag_1 = document.createElement("button");
                    new_tag_1.setAttribute('class', 'comment_button');
                    comment = document.createTextNode("Comment");
                    new_tag_1.appendChild(comment);
                    new_tag.appendChild(new_tag_1);
                    article.appendChild(new_tag);

                    article.appendChild(br.cloneNode());

                    if (posts[i]['delete_right'] == true) {
                        new_tag = document.createElement("div");
                        new_tag.setAttribute('class', 'delete');
                        new_tag_1 = document.createElement("button");
                        new_tag_1.setAttribute('class', 'delete_button');
                        deletee = document.createTextNode("Delete");
                        new_tag_1.appendChild(deletee);
                        new_tag.appendChild(new_tag_1);
                        article.appendChild(new_tag);
                    }

                    timeline = document.getElementById('timeline');
                    timeline.appendChild(article);

                    i++;
                    number_of_posts++;

                }
                update_page_nbrs();
                startup();
    
            }
        }
        xhttp.open("POST", "/php_src/timeline_paginate.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("number_of_posts="+number_of_posts);

    }
}

function update_page_nbrs() {
    buttons = document.getElementsByClassName("a_page_nbr");
    while ( buttons[0] ) {
        number_of_pages.removeChild(buttons[0]);
    }
    posts = document.getElementsByClassName("post");

    last_page = 0;
    pages = document.getElementById("number_of_pages");
    for( var i = 0; i < posts.length; i += 5 ) {
        new_page_nbr = document.createElement("div");
        new_page_nbr.setAttribute('class', 'page_nbr');
        nbr = document.createTextNode(last_page + 1);
        new_page_nbr.appendChild(nbr);
        a = document.createElement("a");
        a.setAttribute('class', 'a_page_nbr');
        a.href = "#"+posts[i].id;
        a.appendChild(new_page_nbr);
        pages.appendChild(a);
        last_page++;
    }
}

window.addEventListener('load', startup, false);