var like_icons = document.getElementsByClassName("like");

Array.prototype.forEach.call(like_icons, function(like, index) {

    like.addEventListener("click", function(){

        alert("you need to log in first");
    });
    
});



