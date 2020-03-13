<?php

function flash_msg($name = '', $msg = '')
{
    if(!empty($name))
    {
        if(!empty($msg))
            $_SESSION[$name] = $msg;
        else if(empty($msg))
        {
            echo $_SESSION[$name];
            unset($_SESSION[$name]);
        }
    }   
}