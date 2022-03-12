<?php
/*upload file into dashboard*/

session_start();

$orderTesting = 0;

if(isset($_POST['submit-file'])){
    $username = $_SESSION['username'];
    $project = $_COOKIE['sessionOpened'];

    /*dashboard order*/
    include_once "dbh.inc.php";
    $getOrder = "SELECT * FROM dashboard WHERE dashboardUse='$username' AND dashboardProject='$project'";
    $getOrderStmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($getOrderStmt, $getOrder)){
        header("location: ../dashboard.php?error=sqlFailure");
    }else{
        mysqli_stmt_execute($getOrderStmt);
        $getOrderResult = mysqli_stmt_get_result($getOrderStmt);
        while($row=mysqli_fetch_assoc($getOrderResult)){
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

    /*get file info*/
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTye = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    /*get file extention*/
    $fileExt = explode(".", $fileName);
    $fileActExt = strtolower(end($fileExt));

    /*allowed files*/
    $allowed = array("jpg", "jpeg", "png");

    /*error handlers*/
    if(in_array($fileActExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 20000000){
                $imgFullName = $fileName.".".uniqid("", true).".".$fileActExt;      /*creates file name for database*/
                $fileDest = "../uploadFile/".$imgFullName;

                include_once "dbh.inc.php";
                
                $upload = "INSERT INTO dashboard (dashboardUse, dashboardProject, dashboardFile, dashboardOrder) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if(!mysqli_stmt_prepare($stmt, $upload)){
                    header("location: ../dashboard.php?error=sqlFailed");
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ssss", $username, $project, $imgFullName, $order);
                    move_uploaded_file($fileTempName, $fileDest);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }

                echo "<p>".$order."</p>";

                /*check connection
                if($conn->query($upload)===TRUE){
                    echo "New record created successfully";
                }else{
                    echo "Error: ".$upload."<br>".$conn->error;
                }*/

                header("location: ../dashboard.php?upload=success");
            }else{
                header("location: ../dashboard.php?error=tooBig");
                exit();
            }
        }else{
            header("location: ../dashboard.php?error=fileError");
            exit();
        }
    }else{
        header("location: ../dashboard.php?error=fileNotAllowed");
        exit();
    }
}