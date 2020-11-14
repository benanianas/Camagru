var like_icons = document.getElementsByClassName("like"),
    modal = document.getElementById("login-modal"),
    modal_content = document.getElementById("login-modal-content");

Array.prototype.forEach.call(like_icons, function(like, index) {

    like.addEventListener("click", function(e){

        modal.style.display = "block";
    });
    
});

modal_content.addEventListener("click", function(e){
    e.stopPropagation();
});

modal.addEventListener("click", function(){
    modal.style.display = "none";
});

document.getElementById("login-close1").addEventListener("click", function(){

    modal.style.display = "none";
});
// infinite pagination start
// *************************
// *************************
// *************************
if (window.performance && window.performance.navigation.type != window.performance.navigation.TYPE_BACK_FORWARD) {
    sessionStorage.setItem("page", 1);
}

var spage = sessionStorage.getItem('page');
var loader = document.getElementById("load-more");
var page = 2;

loader.style.display = "block";
if (spage && spage != 1)
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            var ret = JSON.parse(this.responseText);
            ret.posts.forEach(addPost);
            if(spage == ret.max)
                loader.style.display = "none";
        }
    };
    xhr.open("POST", window.location.href , true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("spage="+spage);
}

loader.onclick = function(){
    if(spage && spage != 1)
        page = parseInt(spage) + 1;
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
            sessionStorage.setItem("page", page);
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

function htmlschars(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') ;
}

function addPost(post, index)
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
            
            }
        }
        if(post.comments[3])
            htmlcode += `<div id='see-all'><a href='${window.location.href}/post/i/${post.img.split('/')[3].split('.')[0]}'>See All comments </a></div>`;
    }

    htmlcode += "</div></div>";
    elm.innerHTML = htmlcode;
    

    loader.parentNode.insertBefore(elm, loader);
    var like = document.getElementsByClassName('like');
    like = like[like.length - 1];
    like.addEventListener("click", function(e){

        modal.style.display = "block";
    });



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
