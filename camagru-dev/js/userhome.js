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

function deleteComment(elm){
    elm.parentNode.parentNode.style.display = "none";
    elm.parentNode.parentNode.previousSibling.style.display = "none";
    document.getElementById("rm-modal").style.display = "none";

    var cmt_id = elm.parentNode.parentNode.previousSibling.getAttribute("data-comment");

    var xhr = new XMLHttpRequest();
    
    // xhr.onreadystatechange = function()
    // {
    //     if(this.readyState == 4 && this.status == 200)
    //     {
    //         console.log(this.responseText);
    //     }
    // };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("delete=1&cmt="+cmt_id+"&token="+csrfToken);

}
function editCmt(elm)
{
    elm.parentNode.style.display = "none";
    
    document.getElementById("edit-input").value = elm.parentNode.parentNode.previousSibling.getElementsByClassName("comment")[0].innerText;
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


    var comment = elm.parentNode.parentNode.previousSibling.getElementsByClassName("comment")[0];

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
            var cmt_id = elm.parentNode.parentNode.previousSibling.getAttribute("data-comment");
            
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

var loader = document.getElementById("load-more");
var page = 2;
loader.onclick = function(){


    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var posts = JSON.parse(this.responseText);
            posts.posts.forEach(addPost);
        }
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("page="+page);
    

    
    page++;
};
function addPost(post)
{
    var elm = document.createElement('div');
    var htmlcode = `
    <div class='post'>
    <div class='post-header'>
    <img class='profile' src='${post.p_photo}'>
                    <div class='username'>${post.username}</div>
                </div>
                <img class='post-img' src='${window.location.href+post.img}' />

                <div class='actions'>
                    <i class='like far fa-heart'></i>
                    <i class='liked fas fa-heart' style='color:red;'></i>
                    <a href='${window.location.href}/post/i/${post.img.split('/')[3].split('.')[0]}'><i class='far fa-comment'></i></a>
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
        for(i=0; i < 2; i++)
        {
            if(post.comments[i])
            {
                htmlcode += `<div id='comment-holder' data-comment='${post.comments[i].id_c}'>
                            <div id='comment'>
                            <span class='c-user'>${post.comments[i].username}</span>
                            <span class='comment'>${post.comments[i].comment}</span>
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
        if(post.comments[2])
            htmlcode += `<div id='see-all'><a href='${window.location.href}/post/i/${post.img.split('/')[3].split('.')[0]}'>See All comments </a></div>`;
    }

    htmlcode += "</div></div>";
    elm.innerHTML = htmlcode;
    

    loader.parentNode.insertBefore(elm, loader);
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

}
