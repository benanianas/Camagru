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
</select>
</span>
<button class="button is-primary" id="snap" onclick="snapIt(1)" disabled>Snap Photo</button>
</div>
<div id="nocamera">
<p> You can uplaod an image from your computer.</p>
<br>

<div class="uploader">
<form id='up-form' action="<?php echo URLROOT?>/post" method="post" enctype="multipart/form-data">
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
</select>
</span>
<button class="btn2 button is-primary" type="button" id="send" onclick="snapIt(0)" disabled><i class="fas fa-paper-plane"></i></button>
<form>
</div>
<div id="err-msg"></div>

</div>
</div>

<div class="images">
</div>
</div>

<div id="modal">
<div class="modal-content">
<span id="close">&times;</span>
<img id="rimg" src="<?php echo URLROOT?>/img/tmp/1b30e8affcf96229f1591389069.png"/>
<div class="modal-buttons">
<button class="button is-success" type="button" id="post-btn">Post</button>
<div class="divider"></div>
<button class="button is-danger" type="button" id="del-btn">Delete</button>
</div>
</div>
</div>

<canvas id="canvas" width="640" height="480"></canvas>
<?php $jsfile = "camera.js"?>
<?php require APPROOT.'/views/inc/footer.php'?>