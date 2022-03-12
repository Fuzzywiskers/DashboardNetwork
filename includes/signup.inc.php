<?php

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $pwdRepeate = $_POST['pwdRepeate'];

    include_once "dbh.inc.php";
    include_once "functions.inc.php";

    echo "Test One: signup.inc.php";


    /*error checking*/
    if(emptyFieldSignup($name, $email, $username, $pwd, $pwdRepeate)){
        header("location: ../signup.php?error=emptyField");
        exit();
    }
    if(invalidUse($username)){
        header("location: ../signup.php?error=invalidUse");
        exit();
    }
    if(invalidEmail($email)){
        header("location: ../signup.php?error=invalidEmail");
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeate)){
        header("location: ../signup.php?error=passwordNotMatched");
        exit();
    }
    if(useExist($conn, $username, $email)){
        header("location: ../signup.php?error=alreadyExists");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else{
    header("location: ../signup.php");
    exit();
}