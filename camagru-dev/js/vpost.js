var like_icons = document.getElementsByClassName("like"),
    like = like_icons[0],
    cmt_icons = document.getElementsByClassName("fa-comment"),
    cmt = cmt_icons[0],
    modal = document.getElementById("login-modal"),
    modal_content = document.getElementById("login-modal-content"),
    input = document.getElementById("comment-input");



    like.addEventListener("click", function(){

        modal.style.display = "block";
    });

    
    
    cmt.addEventListener("click", function(){

        modal.style.display = "block";
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
