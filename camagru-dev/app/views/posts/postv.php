<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/post.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>

<body>
    <div class="thecontent">
    <?php if (isLoggedIn())
        require APPROOT.'/views/inc/home-nav.php';
        else
        require APPROOT.'/views/inc/nav.php';
        ?>
        <div class="posts">


<?php 

            echo "<div class='post'>
                <div class='post-header'>
                    <img class='profile' src='".URLROOT.$data->p_photo."'>
                    <div class='username'>".$data->username."</div>
                </div>
                <img class='post-img' src='".URLROOT.$data->img."' />

                <div class='actions'>
                    <i class='like far fa-heart";
                    if($data->liked)
                        echo " to-hide";
                    echo"'></i>
                    <i class='liked fas fa-heart";
                    if($data->liked)
                        echo " to-show";
                    echo"' style='color:red;'></i>
                    <i class='far fa-comment'></i>
                </div>
                <div id='likes-number'><span class='nbr'>".$data->likes."</span> likes</div>";
                if (isLoggedIn()) echo"<div class='comment-action'>
                    <input id='comment-input' type='text' placeholder='Add a comment...'>
                    <span id='send-comment'>Post</span>
                </div>";
                echo "<div id='comment-err'>Your comment is too long !</div>
                <div class='comments'>";
                if(!$data->comments)
                    echo "<div id='no-comment'>No comment yet !</div>";
                else
                foreach($data->comments as $celm)
                {
                    echo "<div id='comment-holder' data-comment='$celm->id_c'>
                        <div id='comment'>
                        <span class='c-user'>".$celm->username."</span>
                        <span class='comment'>".htmlspecialchars($celm->comment)."</span>
                        </div></div>";
                        if($celm->id == $_SESSION['id'])echo"<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                        <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                        </div><button id='delete-comment' onclick='editCmt(this)'>Edit</button></div></div>
                        ";
                        else if($data->user_id == $_SESSION['id'])echo"<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                        <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                        </div></div></div>
                        ";
                }
                echo "
                </div>
                

            </div>";
            ?>




        </div>

        <div id="rm-modal">
<div class="rm-modal-content">
  <div id="modal-titel">Delete Comment?</div><hr>
  <div id="rm-modal-qust">Are you sure you want to delete this comment?</div>
<span id="close1">&times;</span>
<div class="modal-buttons">
<button class="button is-info is-light" type="button" id="cancel-btn">Cancel</button>
<div class="divider"></div>
<button class="button is-danger is-light" type="button" id="delete-btn">Delete</button>
</div>
</div>
</div>


<div id="edit-modal">
<div class="rm-modal-content">
  <div id="modal-titel">Edit Comment?</div><hr>
  <!-- <div id="rm-modal-qust">Are you sure you want to delete this comment?</div> -->
  <input id="edit-input" type="text"></input>
  <div id="edit-err"></div>
<span id="edit-close1">&times;</span>
<div class="modal-buttons">
<button class="button is-info is-light" type="button" id="edit-cancel-btn">Cancel</button>
<div class="divider"></div>
<button class="button is-danger is-light" type="button" id="edit-delete-btn">Save</button>
</div>
</div>
</div>



<div id="login-modal">
<div id="login-modal-content">
  <div id="modal-titel">You need to Log In first!</div><hr>
  <!-- <div id="rm-modal-qust">Are you sure you want to delete this comment?</div> -->
<span id="login-close1">&times;</span>
<div class="modal-buttons">
<a href="<?php echo URLROOT.'/account/login'?>"><button class="button is-info is-light" type="button" id="edit-cancel-btn">Log In</button></a>
<div class="divider"></div>
<a href="<?php echo URLROOT.'/account/register'?>"><button class="button is-success is-light" type="button" id="edit-delete-btn">Sign Up</button></a>
</div>
</div>
</div>


        <?php if (isLoggedIn())
        $jsfile = "post.js";
        else
        $jsfile = "vpost.js";
        ?>
        <?php require APPROOT.'/views/inc/footer.php'?>