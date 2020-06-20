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