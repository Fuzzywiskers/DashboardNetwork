<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard</title>
</head>
<body>
    
    <nav>
        <div>&plus;</div>
        <!--add a form here for the links-->
        <li>
            <a href="#">Add File</a>
            <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                <input type="file" name="file">
                <button type="submit" name="submit-file">Upload File</button>
            </form>
        </li>
        <li><a href="#">Add Audio</a></li>
        <li><a href="#">Add Image</a></li>
    </nav> 

    <!--connect to project-->
    <?php
    /*define Order*/
    $dashboardOrder = 0;
    /*connect to specific project selected*/
    $username = $_SESSION['username'];
    $project = $_COOKIE['sessionOpened'];

    /*connect to database*/
    include_once "includes/dbh.inc.php";
    $sql = "SELECT * FROM dashboard WHERE dashboardUse = '$username' and dashboardProject = '$project'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "sql statment fail";
    }else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while($row=mysqli_fetch_assoc($result)){
            /*project Order*/
            if($row['dashboardOrder'] > $dashboardOrder){
                $dashboardOrder++;
                $_SESSION['dashOrder'] = $dashboardOrder;
            }else if($row['dashboardOrder'] == $dashboardOrder){
                $_SESSION['dashOrder'] = $dashboardOrder;
            }else if(!$row['dashboardOrder']){
                $_SESSION['dashOrder'] = 0;
            }else{
                header("location: dashboard.php?error=dashOrderNotSet");
            }

            /*echo "<div><img src='uploadFile/".$row['dashboardFile']."' class=".$_SESSION['dashOrder']."></div>";*/
            $filePlace = "SELECT dashboardTop, dashboardLeft FROM dashboard WHERE dashboardUse='$username' AND dashboardProject='$project' AND dashboardOrder=".$_SESSION['dashOrder'].";";
            $fileResult = mysqli_query($conn, $filePlace);
            if(mysqli_num_rows($result)>0){
                $set = mysqli_fetch_assoc($fileResult);
                echo "<div id='dashboardImg' class=".$_SESSION['dashOrder']." name='dashboardImg' style='top: ".$set['dashboardTop']."; left: ".$set['dashboardLeft'].";'><img src='uploadFile/".$row['dashboardFile']."'></div>";    
            }
        }
    }
    ?>

    
<?php
include_once "footer.php";
?>