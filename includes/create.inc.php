<?php

session_start();

if(isset($_POST['submit-project'])){
    /*set variables*/
    $use = $_SESSION['username'];
    $projectOrder = $_SESSION['order'];
    $projectTitle = $_POST['projectTitle'];
    $projectDesc = $_POST['projectDesc'];
    $projectColor = $_POST['bgColor'];

    include_once "dbh.inc.php";
    include_once "functions.inc.php";

    if(emptyFieldProject($projectTitle, $projectDesc)){
        header("location: ../index.php?error=emptyField");
        exit();
    }
    
    if(!$projectOrder){
        $projectOrder = 0;
    }
    
    createProject($conn, $use, $projectTitle, $projectDesc, $projectColor, $projectOrder);
    

}
else{
    header("location: ../index.php");
    exit();
}