var like_icons = document.getElementsByClassName("like"),
    liked_icons = document.getElementsByClassName("liked"),
    likes_num = document.getElementsByClassName("nbr"),
    posts = document.getElementsByClassName("post-img"),
    comment = document.getElementById("comment-input"),
    send = document.getElementById("send-comment"),
    comment_err = document.getElementById("comment-err"),
    empty = document.getElementById("no-comment"),
    comments_div = document.getElementsByClassName("comments"),
    edits = document.getElementsByClassName("op-edit"),
    options = document.getElementsByClassName("options-o");


    // pagination

        // var infinite = true;

    //

// alert(typeof parseInt(like_icons[0].parentElement.nextElementSibling.firstChild.innerHTML));
Array.prototype.forEach.call(like_icons, function(like, index) {

    like.addEventListener("click", function(){

        like.style.display = "none";
        liked_icons[index].style.display = "inline";
        var num = parseInt(likes_num[index].innerHTML);
        likes_num[index].innerHTML = ++num;
        likeToServer(1, posts[index].src);
    });
    
});

Array.prototype.forEach.call(liked_icons, function(liked, index) {

    liked.addEventListener("click", function(){

        liked.style.display = "none";
        like_icons[index].style.display = "inline";
        var num = parseInt(likes_num[index].innerHTML);
        likes_num[index].innerHTML = --num;
        likeToServer(0, posts[index].src);
    });
    
});


function likeToServer(bl, img)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("like="+bl+"&img="+img+"&token="+csrfToken);
}


Array.prototype.forEach.call(edits, function(elm, index){
    elm.addEventListener("click", function (ev) {
        Array.prototype.forEach.call(options, function(elm){
            elm.style.display = "none";
        });
        options[index].style.display = "block";
        ev.stopPropagation(); 
    });
    
});

document.body.addEventListener("click", function () {
    Array.prototype.forEach.call(options, function(elm){
        elm.style.display = "none";
    });
});

function deleteCmt(elm)
{
    elm.parentNode.style.display = "none";
    document.getElementById("rm-modal").style.display = "block";

    document.getElementById("close1").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
    document.getElementById("cancel-btn").onclick = function(){document.getElementById("rm-modal").style.display = "none";};
    document.getElementById("delete-btn").onclick = function(){deleteComment(elm);};
}

function htmlschars(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') ;
}

function deleteComment(elm){

    // var img = elm.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('img')[1].src;
    var img = elm.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('img')[1].src
    img =  img.split('/');
    img = img[img.length - 1];
    img = img.split('.')[0];
    // console.log(img);
    
    //
    // elm.parentNode.parentNode.style.display = "none";
    // elm.parentNode.parentNode.previousElementSibling.style.display = "none";
    //

    document.getElementById("rm-modal").style.display = "none";

    var cmt_id = elm.parentNode.parentNode.previousElementSibling.getAttribute("data-comment");

    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var comments = JSON.parse(this.responseText);
            var htmlcode = "";
            // console.log(comments);
            if (!comments.c[0])
                htmlcode += `<div id='no-comment'>No comment yet !</div>`;
            for(i=0; i < 3; i++)
            {
                if(comments.c[i])
                {
                    htmlcode += `<div id='comment-holder' data-comment='${comments.c[i].id_c}'>
                                <div id='comment'>
                                <span class='c-user'>${comments.c[i].username}</span>
                                <span class='comment'>${htmlschars(comments.c[i].comment)}</span>
                                </div></div>
                                `;
                if(comments.c[0].id == sid)
                
                htmlcode += `<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                </div><button id='delete-comment' onclick='editCmt(this)'>Edit</button></div></div>
                `;
                else if(comment.pid == sid)
                htmlcode += `<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                </div></div></div>
                            `;
                }
            }
            if(comments.c[3])
                htmlcode += `<div id='see-all'><a href='${window.location.href}/post/i/${img}'>See All comments </a></div>`;
                var node = elm.parentNode.parentNode.parentNode;
                node.innerHTML = htmlcode;

            var edit = document.getElementsByClassName("op-edit");
            var option = document.getElementsByClassName("options-o");

            Array.prototype.forEach.call(edit, function(elm, index){
                elm.addEventListener("click", function (ev) {
                    Array.prototype.forEach.call(option, function(elm){
                        elm.style.display = "none";
                    });
                    option[index].style.display = "block";
                    ev.stopPropagation(); 
                });
                
            });
        }
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("delete=1&cmt="+cmt_id+"&token="+csrfToken);

    

}
function editCmt(elm)
{
    elm.parentNode.style.display = "none";
    
    document.getElementById("edit-input").value = elm.parentNode.parentNode.previousElementSibling.getElementsByClassName("comment")[0].innerText;
    document.getElementById("edit-modal").style.display = "block";
    document.getElementById("edit-err").innerText = "";

    document.getElementById("edit-close1").onclick = function(){document.getElementById("edit-modal").style.display = "none";};
    document.getElementById("edit-cancel-btn").onclick = function(){document.getElementById("edit-modal").style.display = "none";};
    document.getElementById("edit-delete-btn").onclick = function(){editComment(elm);};
    document.getElementById("edit-input").addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            editComment(elm);
        }
      });
}

function editComment(elm){


    var comment = elm.parentNode.parentNode.previousElementSibling.getElementsByClassName("comment")[0];

    if(document.getElementById("edit-input").value.trim().length == 0)
    {
        deleteComment(elm);
        document.getElementById("edit-modal").style.display = "none";
    }
    else if (document.getElementById("edit-input").value.trim().length > 500)
        document.getElementById("edit-err").innerText = "Your Comment is too long !";
    else
    {
        if(comment.innerText != document.getElementById("edit-input").value.trim())
        {
            comment.innerText = document.getElementById("edit-input").value.trim();
            var cmt_id = elm.parentNode.parentNode.previousElementSibling.getAttribute("data-comment");
            
            var xhr = new XMLHttpRequest();
    
            // xhr.onreadystatechange = function()
            // {
            //     if(this.readyState == 4 && this.status == 200)
            //     {
            //         // console.log(this.responseText);
            //     }
            // };
            xhr.open("POST", window.location.href , true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xhr.send("edit=1&id="+cmt_id+"&cmt="+document.getElementById("edit-input").value.trim()+"&token="+csrfToken);
        }
        document.getElementById("edit-modal").style.display = "none";
    }

}


// infinite pagination start
// *************************
// *************************
// *************************
if (infinite)
{
    
    var loader = document.getElementById("load-more");
    var n_pagination = document.getElementById("pagination");
    var page = 2;
    loader.style.display = "block";
    n_pagination.style.display = "none";

    var lg = document.getElementById("thelogo");
    lg.innerHTML = '<img src="'+link+'/img/logo.png" style="height: 39px;cursor: pointer;">';
    lg.onclick = function()
    {
        location.reload();
    };


    if(max && max == pageincookies())
        loader.style.display = "none";

    loader.onclick = function(){
        var cookiepage = pageincookies();
        if(cookiepage != 1)
            page = cookiepage+1;
        // alert("i m going to load"+ page +"and in cookie page is"+ pageincookies());
        document.getElementById('load-text').style.display = "none";
        document.getElementById('load-anim').style.display = "block";
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                
                var ret = JSON.parse(this.responseText);
                if (page == ret.max)
                    loader.style.display = "none";
                ret.posts.forEach(addPost);
                document.cookie = "pages="+page;
                page++;
            }
        };
        xhr.open("POST", window.location.href , true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        setTimeout(() => {  
        document.getElementById('load-text').style.display = "block";
        document.getElementById('load-anim').style.display = "none";
        xhr.send("page="+page);
    }, 400);  
    };


    function addPost(post, index)
    {
        var elm = document.createElement('div');
        var htmlcode = `
        <div class='post'>
        <div class='post-header'>
        <img class='profile' src='${post.p_photo}'>
                        <div class='username'>${post.username}</div>
                    </div>
                    <img class='post-img' src='${window.location.href.split('/')[0]+post.img}' />

                    <div class='actions'>
                        <i class='like far fa-heart'></i>
                        <i class='liked fas fa-heart' style='color:red;'></i>
                        <a href='${window.location.href.split('/')[0]}/post/i/${post.img.split('/')[3].split('.')[0]}'><i class='far fa-comment'></i></a>
                    </div>
                    <div id='likes-number'><span class='nbr'>${post.likes}</span> likes</div>
                    <div class='comments'>
        `;

        if (!post.comments[0])
        {
            htmlcode += `<div id='no-comment'>No comment yet !</div>`;
        }
        else
        {
            for(i=0; i < 3; i++)
            {
                if(post.comments[i])
                {
                    htmlcode += `<div id='comment-holder' data-comment='${post.comments[i].id_c}'>
                                <div id='comment'>
                                <span class='c-user'>${post.comments[i].username}</span>
                                <span class='comment'>${htmlschars(post.comments[i].comment)}</span>
                                </div></div>
                                `;
                if(post.comments[0].id == sid)
                
                htmlcode += `<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                </div><button id='delete-comment' onclick='editCmt(this)'>Edit</button></div></div>
                `;
                else if(post.user_id == sid)
                htmlcode += `<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                </div></div></div>
                            `;
                }
            }
            if(post.comments[3])
                htmlcode += `<div id='see-all'><a href='${window.location.href}/post/i/${post.img.split('/')[3].split('.')[0]}'>See All comments </a></div>`;
        }

        htmlcode += "</div></div>";
        elm.innerHTML = htmlcode;
        

        loader.parentNode.insertBefore(elm, loader);
        if(index == 0)
            elm.scrollIntoView({ behavior: 'smooth', block: "start",inline: "end"});


        var llike = document.getElementsByClassName('like');
        llike = llike[llike.length - 1];
        var lliked = document.getElementsByClassName('liked');
        lliked = lliked[lliked.length - 1];
        var nbr = document.getElementsByClassName('nbr');
        nbr = nbr[nbr.length - 1];
        if (post.liked)
            llike.classList.add('to-hide');
        if (post.liked)
            lliked.classList.add('to-show');
            
        llike.addEventListener("click", function(){

            llike.style.display = "none";
            lliked.style.display = "inline";
            var num = parseInt(nbr.innerHTML);
            nbr.innerHTML = ++num;
            likeToServer(1, window.location.href+post.img);
        });

        lliked.addEventListener("click", function(){

            lliked.style.display = "none";
            llike.style.display = "inline";
            var num = parseInt(nbr.innerHTML);
            nbr.innerHTML = --num;
            likeToServer(0, window.location.href+post.img);
        });

        var edit = document.getElementsByClassName("op-edit");
        var option = document.getElementsByClassName("options-o");

        Array.prototype.forEach.call(edit, function(elm, index){
            elm.addEventListener("click", function (ev) {
                Array.prototype.forEach.call(option, function(elm){
                    elm.style.display = "none";
                });
                option[index].style.display = "block";
                ev.stopPropagation(); 
            });
            
        });
    }
}
else
{
    var loader = document.getElementById("load-more");
    var n_pagination = document.getElementById("pagination");
    
    loader.style.display = "none";
    n_pagination.style.display = "block";
}




function pageincookies()
{
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++)
    {
        var ck = cookies[i].split('=');
        if (ck[0].trim() == "pages")
            return(parseInt(ck[1]));
    }
}

// alert(document.cookie);