<?php

session_start();

$username = $_SESSION['username'];
$project = $_COOKIE['sessionOpened'];

include_once "dbh.inc.php";

$sql = "SELECT * FROM dashboard WHERE dashboardUse='$username' and dashboardProject='$project'";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../dashboard.php?error=sqlFailed");
}else{
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $x=0;

    while($row=mysqli_fetch_assoc($result)){
        $statementTop=$project."elY".$x;
        $statementLeft=$project."elX".$x;
        $resizeWidth=$project."resizeWidth".$x;
        $resizeHeight=$project."resizeHeight".$x;

        $top=$_COOKIE[$statementTop];
        $left=$_COOKIE[$statementLeft];
        $reWidth=$_COOKIE[$resizeWidth];
        $reHeight=$_COOKIE[$resizeHeight];

        $update="UPDATE dashboard SET dashboardTop='$top', dashboardLeft='$left', dashboardReWidth='$reWidth', dashboardReHeight='$reHeight' WHERE dashboardUse='$username' AND dashboardProject='$project' AND dashboardOrder='$x';";

        
        if($conn->query($update)===TRUE){
            header("Location: ../dashboard.php");
        }else{
            header("Location: ../dashboard.php?error=updateFailed");
        }
        
        
        $x++;
    }
}

