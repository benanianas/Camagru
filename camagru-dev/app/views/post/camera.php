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
<div class="v_container"> <video id="video" autoplay></video> 
<img class="emoji" src="<?php echo URLROOT?>/img/like.png">
<img class="emoji" src="<?php echo URLROOT?>/img/love.png">
<img class="emoji" src="<?php echo URLROOT?>/img/haha.png">
<img class="emoji" src="<?php echo URLROOT?>/img/sleepy.png">
<img class="emoji" src="<?php echo URLROOT?>/img/sad.png">
<img class="emoji" src="<?php echo URLROOT?>/img/angry.png">
</div>
<span class="select">
<select id="react" onchange="changeEmoji()">
  <option value="none">none</option>
  <option value="like">Like</option>
  <option value="love">Love</option>
  <option value="haha">Haha</option>
  <option value="sleepy">Sleepy</option>
  <option value="sad">Sad</option>
  <option value="angry">Angry</option>
</select>
</span>
<button class="button is-primary" id="snap" disabled>Snap Photo</button>
</div>
<div id="nocamera">
<div class="file">
  <label class="file-label">
    <input class="file-input" type="file" name="resume">
    <span class="file-cta">
      <span class="file-icon">
        <i class="fas fa-upload"></i>
      </span>
      <span class="file-label">
        Choose a file…
      </span>
    </span>
  </label>
</div>
</div>

</div>

<div class="images">
</div>
</div>
<canvas id="canvas" width="640" height="480"></canvas>
<?php $jsfile = "camera.js"?>
<?php require APPROOT.'/views/inc/footer.php'?>