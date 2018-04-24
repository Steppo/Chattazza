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
            $host="127.0.0.1";
            $user=$_POST["username"];
            $password=$_POST["password"];
            /* connessione */
            $connection=mysqli_connect($host
            6,$user,$password);
            or die("errore di connessione");
            /* selezione db */
            mysqli_select_db($connection,"chat") or die("errore nella selezione del db");
            mysqli_close($connection);
        }
        if(isset($_POST['sign_up']))
            header('Location: /chattazza/chat/html/signup.html');
    }
?>