<?php

/*create function for assigning number to div*/
function uploadNum($use, $pro, $order, $conn){
    $orderTesting = 0;
    $order = 0;
    $getOrder = "SELECT * FROM dashboard WHERE dashboardUse='$use' AND dashboardProject='$pro'";
    $getOrderStmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($getOrderStmt, $getOrder)){
        header("location: ../dashboard.php?error=stmtFailed");
    }else{
        mysqli_stmt_execute($getOrderStmt);
        $getOrderResult = mysqli_stmt_get_result($getOrderStmt);
        while($row = mysqli_fetch_assoc($getOrderResult)){
            if($row['dashboardOrder'] >= $orderTesting){
                $orderTesting++;
                $order = $orderTesting;
            }else if(!$order){
                $order = 0;
            }
        }
        if(!$order){
            $order = 0;
        }else if($order){
            echo $order;
        }else{
            header("location: ../dashboard.php?error=orderFailure");
        }
    }
    
    return $order;
}