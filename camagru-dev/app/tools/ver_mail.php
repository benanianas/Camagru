<?php

function sendVerification($data, $token)
{
    $sender = 'no-reply@camagru.social';
    $recipient = $data['email'];

    $subject = "Camagru verification mail";
    $link = URLROOT."/account/verify/".$token;
    $message = "please ".$data['first_name']." verify your email ".$link;
    $headers = 'From: Camagru <' . $sender.">"; 

    mail($recipient, $subject, $message, $headers);
}