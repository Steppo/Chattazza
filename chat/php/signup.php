<?php
    session_start();
    if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['confirm_password']) || !isset($_POST['email'])){
        header('Location: /chattazza/chat/html/signup.html');
        die(); 
    }  
    else{
        if(isset($_POST['sign_up']))
        {
            echo "Sign up <BR>";
            $host="127.0.0.1";
            $login="root";

            $user=$_POST['username'];
            $password=$_POST['password'];
            $name=$_POST['name'];
            $surname=$_POST['surname'];
            $email=$_POST['email'];
            /* connessione */
            $connection=mysqli_connect($host,$login,'')
            or die(alert('errore di connessione'));

            /* selezione db */
            mysqli_select_db($connection,'chat') or die(alert('errore nella selezione del db'));

            /* inserimento dati nel DB */
            $query="INSERT INTO 'users' (IdUsePk, username, password, email, name, surname)
                    VALUES (, '$surname', '$password', '$email', '$name', '$surname')";
            mysqli_query($connection, $query) or die(alert('errore inserimento dati'));

            mysqli_close($connection);
        }
    }

    function alert($message){
        echo "<script type='text/javascript'> alert('$message');</script>";
    }
?>