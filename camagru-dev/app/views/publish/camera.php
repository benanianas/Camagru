<?php require APPROOT.'/views/inc/header.php'?>
<link rel="stylesheet" href="<?php echo URLROOT?>/css/navbar.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/camera.css">
<link rel="stylesheet" href="<?php echo URLROOT?>/css/footer.css">
</head>
<body>
<div class="thecontent">
<?php require APPROOT.'/views/inc/home-nav.php'?>

<div class="camera">
<div class="photobooth"> 
<div id="withcamera">
<div class="v_container"> 
<div id="camera-err">Camera isn't working</div>
<video id="video" autoplay></video> 
<img class="emoji" src="<?php echo URLROOT?>/img/like.png">
<img class="emoji" src="<?php echo URLROOT?>/img/love.png">
<img class="emoji" src="<?php echo URLROOT?>/img/haha.png">
<img class="emoji" src="<?php echo URLROOT?>/img/sleepy.png">
<img class="emoji" src="<?php echo URLROOT?>/img/sad.png">
<img class="emoji" src="<?php echo URLROOT?>/img/angry.png">
<img class="emoji" src="<?php echo URLROOT?>/img/mina3ima.png">
<img class="emoji" src="<?php echo URLROOT?>/img/niba.png">
<img class="emoji" src="<?php echo URLROOT?>/img/raghibamine.png">
<img class="emoji" src="<?php echo URLROOT?>/img/tasir.png">

</div>
<span class="select">
<select id="react" disabled onchange="changeEmoji()">
  <option value="none">none</option>
  <option value="like">Like</option>
  <option value="love">Love</option>
  <option value="haha">Haha</option>
  <option value="sleepy">Sleepy</option>
  <option value="sad">Sad</option>
  <option value="angry">Angry</option>
  <option value="mina3ima">mi na3ima</option>
  <option value="raghibamine">raghibe amine</option>
  <option value="niba">niba</option>
  <option value="tasir">ta sir</option>
</select>
</span>
<button class="button is-primary" id="snap" onclick="snapIt(1)" disabled>Snap Photo</button>
</div>
<div id="nocamera">
<p> You can uplaod an image from your computer.</p>
<br>

<div class="uploader">
<form id='up-form' action="<?php echo URLROOT?>/camera" method="post" enctype="multipart/form-data">
  <label class="file-label">
    <input id="up-pic" class="file-input" type="file" name="file" onchange="enableBtn()">
    <span class="file-cta">
      <span class="file-icon">
        <i class="fas fa-upload"></i>
      </span>
      <span class="file-label">
        Choose a file…
      </span>
    </span>
  </label>

  <span class="select">
<select id="react2" name="selected" onclick="enableBtn()">
  <option value="none">none</option>
  <option value="like">Like</option>
  <option value="love">Love</option>
  <option value="haha">Haha</option>
  <option value="sleepy">Sleepy</option>
  <option value="sad">Sad</option>
  <option value="angry">Angry</option>
  <option value="mina3ima">mi na3ima</option>
  <option value="raghibamine">raghibe amine</option>
  <option value="niba">niba</option>
  <option value="tasir">ta sir</option>
</select>
</span>
<button class="btn2 button is-primary" type="button" id="send" onclick="snapIt(0)" disabled><i class="fas fa-paper-plane"></i></button>
<form>
</div>
<div id="err-msg"></div>

</div>
</div>

<div id="images">
<?php
if($data)
{
  foreach ($data as $elm)
  {
    echo '<div id="img-container"><img src="'.URLROOT.$elm->img.'"><button class="rm-btn button is-danger" type="button">Delete</button></div>';
  }
  echo "<div id='emptymsg' style='display: none;'> No Post found!</div>";
}
else{
  echo "<div id='emptymsg'> No Post found!</div>";
}
?>

</div>
</div>

<div id="modal">
<div class="modal-content">
<span id="close">&times;</span>
<img id="rimg" src="<?php echo URLROOT?>/img/tmp/1b30e8affcf96229f1591389069.png"/>
<div class="modal-buttons">
<button class="button is-success" type="button" id="post-btn">Post</button>
<div class="divider"></div>
<button class="button is-danger" type="button" id="del-btn">Cancel</button>
</div>
</div>
</div>

<div id="rm-modal">
<div class="rm-modal-content">
  <div id="modal-titel">Delete Post?</div><hr>
  <div id="rm-modal-qust">Are you sure you want to delete this post?</div>
<span id="close1">&times;</span>
<div class="modal-buttons">
<button class="button is-info is-light" type="button" id="cancel-btn">Cancel</button>
<div class="divider"></div>
<button class="button is-danger is-light" type="button" id="delete-btn">Delete</button>
</div>
</div>
</div>

<canvas id="canvas" width="640" height="480"></canvas>
<?php $jsfile = "camera.js"?>
<?php require APPROOT.'/views/inc/footer.php'?>