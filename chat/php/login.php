<?php
    session_start();
    if(!isset($_POST['username']) || !isset($_POST['password'])){
        header('Location: /chattazza/index.html');
        die();
    }  
    else{
        if(isset($_POST['login']))
        {
            echo "Login";
            
        }
        if(isset($_POST['sign_up']))
            header('Location: /chattazza/chat/html/signup.html');
    }
?>