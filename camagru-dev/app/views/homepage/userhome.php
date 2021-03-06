<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/home.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>

<body>
    <div class="thecontent">
        <?php 
        if (isLoggedIn())
        require APPROOT.'/views/inc/home-nav.php';
        else
        require APPROOT.'/views/inc/nav.php';
        ?>
        <div class="posts">


<?php 
foreach($data['posts'] as $elm)
{
            echo "<div class='post'>
                <div class='post-header'>
                    <img class='profile' src='".URLROOT.$elm->p_photo."'>
                    <div class='username'>".$elm->username."</div>
                </div>
                <img class='post-img' src='".URLROOT.$elm->img."' />

                <div class='actions'>
                    <i class='like far fa-heart";
                    if(property_exists($elm, 'liked') && $elm->liked)
                        echo " to-hide";
                    echo"'></i>
                    <i class='liked fas fa-heart";
                    if(property_exists($elm, 'liked') && $elm->liked)
                        echo " to-show";
                    echo"' style='color:red;'></i>
                    <a href='";
                    $tmp = explode('/',$elm->img);
                    $tmp = end($tmp);
                    echo URLROOT.'/post/i/'.explode('.',$tmp)[0];
                    echo "'><i class='far fa-comment'></i></a>
                </div>
                <div id='likes-number'><span class='nbr'>".$elm->likes."</span> likes</div>

                <div class='comments'>";
                // foreach($elm->comments as $celm)
                if(!$elm->comments)
                    echo "<div id='no-comment'>No comment yet !</div>";
                
                else
                {
                    for($i = 0; $i < 3; $i++)
                    {
                        if (array_key_exists($i,$elm->comments))
                        {
                        echo "<div id='comment-holder' data-comment='".$elm->comments[$i]->id_c."'>
                            <div id='comment'>
                            <span class='c-user'>".$elm->comments[$i]->username."</span>
                            <span class='comment'>".htmlspecialchars($elm->comments[$i]->comment)."</span>
                            </div></div>";
                            if($elm->comments[$i]->id == $_SESSION['id'])echo"<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                        <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                        </div><button id='delete-comment' onclick='editCmt(this)'>Edit</button></div></div>
                        ";
                        else if($elm->user_id == $_SESSION['id'])echo"<div class='edit-o' id='edit'><i class='op-edit fas fa-ellipsis-v'></i>
                        <div class='options-o' id='options'><button id='delete-comment' onclick='deleteCmt(this)'>Delete</button><div id='btn-spr'>
                        </div></div></div>
                        ";
                        }
                    }
                    if(array_key_exists('3',$elm->comments))
                    echo "<div id='see-all'><a href='".URLROOT.'/post/i/'.explode('.',end(explode('/',$elm->img)))[0]."'>See All comments </a></div>";
                }
                echo "
                </div>
               

            </div>";
}
            ?>
            <?php 
            $prev = $data['page'] - 1;
            $next = $data['page'] + 1;
            
            ?>
            <div id="pagination">
            <?php if($prev != 0) echo "<a href='".URLROOT."?page=".$prev."'>";?>
            <i id="left" class="p-btn fas fa-arrow-circle-left" <?php if($prev == 0) echo "style='opacity: 0.5;'";?>></i>
            <?php if($prev != 0) echo"</a>";?>
            <div id="p-divider"></div>
            <?php if($next <= $data['max']) echo "<a href='".URLROOT."?page=".$next."'>";?>
            <i id="right" class="p-btn fas fa-arrow-circle-right" <?php if($next > $data['max']) echo "style='opacity: 0.5;'";?>></i>
            <?php if($next <= $data['max']) echo "</a>";?>
            </div>

        <div id="load-more">
        <span id="load-text">See More</span>
        <div id="load-anim" class="loader"></div>
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
</div>

        <?php if (isLoggedIn())
        $jsfile = "userhome.js";
        else
        $jsfile = "vhome.js";
        ?>
        <?php require APPROOT.'/views/inc/footer.php'?>