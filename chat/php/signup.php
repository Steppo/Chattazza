<?php
    session_start();
    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm_password']) || !isset($_POST['email'])){
        header('Location: /chattazza/chat/html/signup.html');
        die(); 
    }  
    else{
        if(isset($_POST['sign_up']))
            echo "Sign up";
    }
?>