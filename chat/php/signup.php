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
            $conf_pass=$_POST['confirm_password'];
            $name=$_POST['name'];
            $surname=$_POST['surname'];
            $email=$_POST['email'];

            if($password!=$conf_pass)
                die(alert('password sbagliata'));

            /* connessione */
            $connection=mysqli_connect($host,$login,'')
            or die(alert('errore di connessione'));

            /* selezione db */
            mysqli_select_db($connection,'chat') or die(alert('errore nella selezione del db'));

            /* inserimento dati nel DB */
            $table="users";
            $query="INSERT INTO $table (username, psw, email, nome, surname)
                    VALUES ('$user', '$password', '$email', '$name', '$surname')";
            mysqli_query($connection, $query) or die(alert('errore inserimento dati'));

            mysqli_close($connection);
        }
    }

    function alert($message){
        echo "<script type='text/javascript'> alert('$message');</script>";
    }
?>