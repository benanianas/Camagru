<div class="push" ></div>
</div>
<footer class='myfooter'>
    Made with <i style='color:red;' class="fas fa-heart"></i> by Abenani <br> &copy; 2020 Camagru
</footer>
<?php
if (isLoggedIn())
echo 
"<script>
var csrfToken = '".$_SESSION["token"]."';
var sid = '".$_SESSION['id']."'
</script>";
?>
<?php echo "<script>
var infinite = false;
var link = '".URLROOT."';";
if ( is_array($data) && array_key_exists('max', $data))
    echo "var max ='".$data['max']."';";
echo "</script>";?>
<script src="<?php echo URLROOT ?>/js/main.js";></script>
<?php if(isset($jsfile)) echo '<script src="'.URLROOT.'/js/'.$jsfile.'";></script>'?>
</body>
</html>