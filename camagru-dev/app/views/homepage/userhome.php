<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/home.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>

<body>
    <div class="thecontent">
        <?php require APPROOT.'/views/inc/home-nav.php'?>
        <div class="posts">


<?php 
foreach($data as $elm)
{
            echo "<div class='post'>
                <div class='post-header'>
                    <img class='profile' src='".URLROOT.$elm->p_photo."'>
                    <div class='username'>".$elm->username."</div>
                </div>
                <img class='post-img' src='".URLROOT.$elm->img."' />

                <div class='actions'>
                    <i class='like far fa-heart";
                    if($elm->liked)
                        echo " to-hide";
                    echo"'></i>
                    <i class='liked fas fa-heart";
                    if($elm->liked)
                        echo " to-show";
                    echo"' style='color:red;'></i>
                    <i class='far fa-comment'></i>
                    <i class='far fa-paper-plane'></i>
                </div>
                <div id='likes-number'><span class='nbr'>".$elm->likes."</span> likes</div>

                <div class='comments'>";
                foreach($elm->comments as $celm)
                {
                    echo "<div id='comment-holder'>
                        <div id='comment'>
                        <span class='c-user'>".$celm->username."</span>
                        <span class='comment'>".$celm->comment."</span>
                        </div></div>
                        <div id='edit'><i class='fas fa-ellipsis-v'></i></div>
                        ";
                }
                echo "
                </div>
                <div class='comment-action'>
                    <input type='text' placeholder='Add a comment...'>
                    <span id='send-comment'>Post</span>
                </div>

            </div>";
}
            ?>




        </div>
        <?php $jsfile = "userhome.js"?>
        <?php require APPROOT.'/views/inc/footer.php'?>