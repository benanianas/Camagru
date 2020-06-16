var like_icons = document.getElementsByClassName("like"),
    liked_icons = document.getElementsByClassName("liked"),
    likes_num = document.getElementsByClassName("nbr"),
    posts = document.getElementsByClassName("post-img");

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
        xhr.send("like="+bl+"&img="+img);
}