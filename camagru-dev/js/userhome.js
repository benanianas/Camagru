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
    
        // xhr.onreadystatechange = function()
        // {
        //     if(this.readyState == 4 && this.status == 200)
        //     {
        //         console.log(this.responseText);
        //     }
        // };
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
    
            xhr.onreadystatechange = function()
            {
                if(this.readyState == 4 && this.status == 200)
                {
                    console.log(this.responseText);
                }
            };
            xhr.open("POST", window.location.href , true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
            xhr.send("edit=1&id="+cmt_id+"&cmt="+document.getElementById("edit-input").value.trim()+"&token="+csrfToken);
        }
        document.getElementById("edit-modal").style.display = "none";
    }

}