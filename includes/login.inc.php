<?php

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];

    include_once "dbh.inc.php";
    include_once "functions.inc.php";

    if(emptyFieldLogin($username, $pwd)){
        header("location: ../login.php?error=emptyField");
        exit();
    }
    
    loginUser($conn, $username, $pwd);

}
else{
    header("location: ../login.php");
    echo "Test 1: else statments";
}