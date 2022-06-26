<?php
/*upload file into dashboard*/

session_start();
include "dbh.inc.php";

if(isset($_POST['submit-file'])){
    $username = $_SESSION['username'];
    $project = $_COOKIE['sessionOpened'];
    $order;

    /*dashboard order*/
    include_once "phpFunctions.inc.php";
    $order = uploadNum($username, $project, $order, $conn);

    /*get file info*/
    $fileOne = $_FILES['fileOne'];
    $fileName = $fileOne['name'];
    $fileTempName = $fileOne['tmp_name'];
    $fileError = $fileOne['error'];
    $fileSize = $fileOne['size'];
    $fileType = "img";

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
                
                $upload = "INSERT INTO dashboard (dashboardUse, dashboardProject, dashboardFile, dashboardOrder, fileType, fileExt) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if(!mysqli_stmt_prepare($stmt, $upload)){
                    header("location: ../dashboard.php?error=sqlFailed");
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $project, $imgFullName, $order, $fileType, $fileActExt);
                    move_uploaded_file($fileTempName, $fileDest);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
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

if(isset($_POST['submit-video'])){
    $usernameTwo = $_SESSION['username'];
    $projectTwo = $_COOKIE['sessionOpened'];
    $orderTwo = 0;

    /*create order for video*/
    include_once "phpFunctions.inc.php";
    $orderTwo = uploadNum($usernameTwo, $projectTwo, $orderTwo, $conn);

    /*get file info*/
    $fileTwo = $_FILES['fileTwo'];
    $fileTwoName = $fileTwo['name'];
    $fileTwoTempName = $fileTwo['tmp_name'];
    $fileTwoError = $fileTwo['error'];
    $fileTwoSize = $fileTwo['size'];

    if(empty($error) == True){
        /*get file ext*/
        $fileTwoExt = explode(".", $fileTwoName);
        $fileTwoActExt = strtolower(end($fileTwoExt));
        $fileTwoType = "video";

        /*allowed extenstions*/
        $allowedTwo = array("mp4", "avi", "3gp", "mov", "mpeg");
        if(in_array($fileTwoActExt, $allowedTwo)){
            /*check file to see if it is good to be uploaded*/
            if($fileTwoSize < 200000000){
                $upload = "INSERT INTO dashboard (dashboardUse, dashboardProject, dashboardFile, dashboardOrder, fileType, fileExt) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if($conn->connection_error){
                    die("Connection Failed: ".$conn->connection_error);
                }
                if(!mysqli_stmt_prepare($stmt, $upload)){
                    header("location: ../dashboard.php?error=sqlFailed");
                }else{
                    mysqli_stmt_bind_param($stmt, "ssssss", $usernameTwo, $projectTwo, $fileTwoName, $orderTwo, $fileTwoType, $fileTwoActExt);
                    move_uploaded_file($fileTwoTempName, "../uploadFile/".$fileTwoName);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                header("location: ../dashboard.php?uploade=success");
            }else{
            header("location: ../dashboard.php?error=fileSizeTooBig");
            }
        }else{
        header("location: ../dashboard.php?error=fileTypeNotAllowed");
        }
    }else{
    header("location: ../dashboard.php?error=errorInFile");
    }
}


/*upload audio*/
if(isset($_POST['submit-audio'])){
    $username3 = $_SESSION['username'];
    $project3 = $_COOKIE['sessionOpened'];
    $order3 = 0;

    /*create order*/
    include_once "phpFunctions.inc.php";
    $order3 = uploadNum($username3, $project3, $order3, $conn);

    /*get file info*/ 
    $file3 = $_FILES['fileThree'];
    $fileName3 = $file3['name'];
    $fileTempName3 = $file3['tmp_name'];
    $fileError3 = $file3['error'];
    $fileSize3 = $file3['size'];

    if(empty($fileError3) == True){
        /*get file extension*/
        $fileActExt3 = strtolower(explode(".", $fileName3)[1]);
        $fileType3 = "audio";
        $allowed3 = array("m4a", "flac", "mp3", "wav", "wma", "aac");

        if(in_array($fileActExt3, $allowed3)){
            if($fileSize3 < 2000000){
                $upload = "INSERT INTO dashboard (dashboardUse, dashboardProject, dashboardFile, dashboardOrder, fileType, fileExt) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if($conn->connect_error){
                    die("connection failed: ".$conn->connect_error);
                }
                if(!mysqli_stmt_prepare($stmt, $upload)){
                    header("location: ../dashboard.php?error=sqlFailed");
                }else{
                    mysqli_stmt_bind_param($stmt, "ssssss", $username3, $project3, $fileName3, $order3, $fileType3, $fileActExt3);
                    move_uploaded_file($fileTempName3, "../uploadFile/".$fileName3);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                header("location: ../dashboard.php?uploade=success");
            }else{
                header("location: ../dashboard.php?error=fileSizeTooBig");
            }
        }else{
            header("location: ../dashboard.php?error=fileTypeNotAllowed");
        }
    }else{
        header("location: ../dashbord.php?error=fileHadError");
    }
}