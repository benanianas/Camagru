<?php require APPROOT.'/views/inc/header.php'?>

<h2 style="text-align:center;">Registration Page</h2>
<div class="registration-box">
<form action="<?php echo URLROOT?>/account/register" method="post">
<label for="full_name">Name: <sup>*</sup></label>
<input type='text' name='full_name'>
<br>
<label for="full_name">Username: <sup>*</sup></label>
<input type='text' name='full_name'>
<br>

<label for="full_name">Email: <sup>*</sup></label>
<input type='text' name='full_name'>
<br>

<label for="full_name">Password: <sup>*</sup></label>
<input type='password' name='full_name'>
<br>

<label for="full_name">Confirm Password: <sup>*</sup></label>
<input type='password' name='full_name'>
<br>
<input type='submit' name='Register'>

</form>
</div>

<?php require APPROOT.'/views/inc/footer.php'?>
