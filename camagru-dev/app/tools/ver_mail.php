<?php

$s_email = 'camagru.social.noreply@gmail.com';
function sendVerification($data, $token)
{
    $sender = $s_email;
    $recipient = $data['email'];

    $subject = "Camagru verification mail";
    $link = URLROOT."/account/verify/".$token;
    $message = " <img style='display:block;margin: 0 auto;' src='".URLROOT."/img/camagrugreen.png'>";
    $message .= "<div class='mail' style ='padding: 40px; '><h1>Reset Your Password</h1>";
    $message .= "Hi ".$data['first_name'].", Tap the button below to confirm your email address. If you didn't create an account with Camagru, you can safely delete this email.<br>";
    $message .= "this link expires after 24 hours.<br>";
    $message .= "<div style='margin-top:20px; margin-bottom: 20px; text-align: center; width: 100%;'><a href='".$link."' style='background-color: #00C99C;border: none;color: white;padding: 15px 32px;
    text-align: center;text-decoration: none;display: inline-block;font-size: 16px;width:80px;margin: auto;
    cursor: pointer;border-radius: 5px;text-align:center;'>Verify Now</a></div>";
    $message .= "If that doesn't work, copy and paste the following link in your browser:<br>".$link;
    $message .= "<br><br><br><br>Cheers,<br>Camagru";
    $headers = 'From: Camagru <' . $sender.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "content-Type: text/html; charset=ISO-8859-1\r\n"; 

    mail($recipient, $subject, $message, $headers);
}

function sendPasswordReset($data, $token)
{
    $sender = $s_email;
    $recipient = $data['email'];

    $subject = "Camagru Reset Password";
    $link = URLROOT."/account/reset_password/".$token;
    $message = " <img style='display:block;margin: 0 auto;' src='".URLROOT."/img/camagrugreen.png'>";
    $message .= "<div class='mail' style ='padding: 40px; '><h1>Reset Your Password</h1>";
    $message .= "Hi ".$data['first_name'].", Tap the button below to reset your account password. If you didn't request a new password, you can safely delete this email.<br>";
    $message .= "this link expires after 2 hours.<br>";
    $message .= "<div style='margin-top:20px; margin-bottom: 20px; text-align: center; width: 100%;'><a href='".$link."' style='background-color: #00C99C;border: none;color: white;padding: 15px 32px;
    text-align: center;text-decoration: none;display: inline-block;font-size: 16px;width:80px;margin: auto;
    cursor: pointer;border-radius: 5px;text-align:center;'>Reset Now</a></div>";
    $message .= "If that doesn't work, copy and paste the following link in your browser:<br>".$link;
    $message .= "<br><br><br><br>Cheers,<br>Camagru";
    $headers = 'From: Camagru <' . $sender.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "content-Type: text/html; charset=ISO-8859-1\r\n"; 

    mail($recipient, $subject, $message, $headers);
}


function sendLikeNotif($data)
{
    $sender = $s_email;
    $recipient = $data->email;

    $subject = "Someone Liked your Post";
    $link = $data->link;
    $message = " <img style='display:block;margin: 0 auto;' src='".URLROOT."/img/camagrugreen.png'>";
    $message .= "<div class='mail' style ='padding: 40px; '><h1>See What's New</h1>";
    $message .= "Hi ".$data->first_name.", ".$_SESSION['username']." Liked Your Post.<br>";
    $message .= "<div style='margin-top:20px; margin-bottom: 20px; text-align: center; width: 100%;'><a href='".$link."' style='background-color: #00C99C;border: none;color: white;padding: 15px 32px;
    text-align: center;text-decoration: none;display: inline-block;font-size: 16px;width:80px;margin: auto;
    cursor: pointer;border-radius: 5px;text-align:center;'>See Post</a></div>";
    $message .= "If that doesn't work, copy and paste the following link in your browser:<br>".$link;
    $message .= "<br><br><br><br>Cheers,<br>Camagru";
    $headers = 'From: Camagru <' . $sender.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "content-Type: text/html; charset=ISO-8859-1\r\n"; 

    mail($recipient, $subject, $message, $headers);
}

function sendCommentNotif($data)
{
    $sender = $s_email;
    $recipient = $data->email;

    $subject = "Someone commented on your Post";
    $link = $data->link;
    $message = " <img style='display:block;margin: 0 auto;' src='".URLROOT."/img/camagrugreen.png'>";
    $message .= "<div class='mail' style ='padding: 40px; '><h1>See What's New</h1>";
    $message .= "Hi ".$data->first_name.", ".$_SESSION['username']." commented on Your Post.<br>";
    $message .= "<div style='margin-top:20px; margin-bottom: 20px; text-align: center; width: 100%;'><a href='".$link."' style='background-color: #00C99C;border: none;color: white;padding: 15px 32px;
    text-align: center;text-decoration: none;display: inline-block;font-size: 16px;width:80px;margin: auto;
    cursor: pointer;border-radius: 5px;text-align:center;'>See The comment</a></div>";
    $message .= "If that doesn't work, copy and paste the following link in your browser:<br>".$link;
    $message .= "<br><br><br><br>Cheers,<br>Camagru";
    $headers = 'From: Camagru <' . $sender.">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "content-Type: text/html; charset=ISO-8859-1\r\n"; 

    mail($recipient, $subject, $message, $headers);
}