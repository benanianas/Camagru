var like_icons = document.getElementsByClassName("like"),
    liked_icons = document.getElementsByClassName("liked"),
    likes_num = document.getElementsByClassName("nbr"),
    posts = document.getElementsByClassName("post-img"),
    like = like_icons[0],
    liked = liked_icons[0],
    likes = likes_num[0],
    post = posts[0],
    comment = document.getElementById("comment-input"),
    send = document.getElementById("send-comment"),
    comment_err = document.getElementById("comment-err"),
    empty = document.getElementById("no-comment"),
    comments_div = document.getElementsByClassName("comments"),
    edits = document.getElementsByClassName("op-edit"),
    options = document.getElementsByClassName("options-o");


comment.addEventListener("input", function(){

    if (comment.value.trim().length == 0)
    {
        send.removeEventListener("click", sendComment);
        send.style.opacity = "0.5";
        send.style.cursor = "auto";
        comment_err.style.display = "none";
    }
    
    else if(comment.value.trim().length <= 500)
    {
        send.style.opacity = "1";
        send.style.cursor = "pointer";
        send.addEventListener("click", sendComment);
        comment_err.style.display = "none";
    }
    else
    {
        send.removeEventListener("click", sendComment);
        send.style.opacity = "0.5";
        send.style.cursor = "auto";
        comment_err.style.display = "block";
    }
    
});

comment.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     send.click();
    }
  });


var sendComment = function(){
 
    if(empty != null)
        empty.style.display = "none";
    
    send.removeEventListener("click", sendComment);
    send.style.opacity = "0.5";
    send.style.cursor = "auto";
    comment_err.style.display = "none";
    if (comment.value.trim().length >0)
    {
    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            // username = this.responseText;

            var newcomment = document.createElement("div");
            newcomment.innerHTML = "<div id='comment-holder' data-comment='"+this.responseText.split('/')[1]+"'><div id='comment'><span class='c-user'>"+
            this.responseText.split('/')[0]+
            " </span><span class='comment'>ok</span></div></div><div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i><div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'></div><button id='delete-comment' onclick='editCmt(this)'>Edit</button></div></div>";
            comments_div[0].insertBefore(newcomment, comments_div[0].firstChild);
            document.getElementsByClassName("comment")[0].innerText = comment.value.trim();
            comment.value = "";
            
            Array.prototype.forEach.call(edits, function(elm, index){
                elm.addEventListener("click", function (ev) {
                    Array.prototype.forEach.call(options, function(elm){
                        elm.style.display = "none";
                    });
                    options[index].style.display = "block";
                    ev.stopPropagation(); 
                });
                
            });
            if(this.responseText.split('/')[1])
                sendCommentNotif(window.location.href);
        }
    };

    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("comment="+comment.value.trim()+"&post="+window.location.href+"&token="+csrfToken);
}

};


function sendCommentNotif(link)
{
    var xhr = new XMLHttpRequest();


    // xhr.onreadystatechange = function()
    //         {
    //             if(this.readyState == 4 && this.status == 200)
    //             {
    //                 console.log(this.responseText);
    //             }
    //         };
    
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("cmt-notif=1&link="+link+"&token="+csrfToken);
}



like.addEventListener("click", function(){

    like.style.display = "none";
    liked.style.display = "inline";
    var num = parseInt(likes.innerHTML);
    likes.innerHTML = ++num;
    likeToServer(1, post.src);
});




liked.addEventListener("click", function(){

    liked.style.display = "none";
    like.style.display = "inline";
    var num = parseInt(likes.innerHTML);
    likes.innerHTML = --num;
    likeToServer(0, post.src);
});


function likeToServer(bl, img)
{
    var xhr = new XMLHttpRequest();


    // xhr.onreadystatechange = function()
    //         {
    //             if(this.readyState == 4 && this.status == 200)
    //             {
    //                 console.log(this.responseText);
    //             }
    //         };
    
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
    
            
            xhr.open("POST", window.location.href , true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xhr.send("edit=1&id="+cmt_id+"&cmt="+document.getElementById("edit-input").value.trim()+"&token="+csrfToken);
        }
        document.getElementById("edit-modal").style.display = "none";
    }

}