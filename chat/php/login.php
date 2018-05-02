<?php
    session_start();
    if(!isset($_POST['username']) || !isset($_POST['password'])){
        header('Location: /chattazza/index.html');
        die();
    }  
    else{
        if(isset($_POST['login']))
        {
            echo "Login <BR>";
            $host="127.0.0.1";
            $login="root";

            $user=$_POST["username"];
            $password=$_POST["password"];
            
            /* connessione */
            $connection=mysqli_connect($host,$login,'')
            or die(alert('errore di connessione'));
            /* selezione db */
            mysqli_select_db($connection,'chat') or die(alert('errore nella selezione del db'));

            /* controllo dati */
            $query="SELECT U.username, U.psw
                    FROM users AS U
                    WHERE U.username='$user' AND U.psw='$password'";
            mysqli_query($connection, $query) or die(alert('errore'));

            mysqli_close($connection);
        }
        if(isset($_POST['sign_up']))
            header('Location: /chattazza/chat/html/signup.html');
    }

    function alert($message){
        echo "<script type='text/javascript'> alert('$message');</script>";
    }
?>