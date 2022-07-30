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

    <!--gear css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php
if(!isset($_SESSION['username'])){
    header("location: index.php");
}
include_once "includes/dbh.inc.php";
$username = $_SESSION['username'];
$project = $_COOKIE['sessionOpened'];
$backgroundSQL = "SELECT projectBackground FROM projects WHERE projectUse='$username' AND projectOrder='$project'";
$stmt = mysqli_stmt_init($conn);
$backgroundResult = mysqli_query($conn, $backgroundSQL);
$backgroundSet = mysqli_fetch_assoc($backgroundResult);

if(!mysqli_stmt_prepare($stmt, $backgroundSQL)){
    echo "<body>";
}else{
    echo "<body style='background-image: url(uploadFile/".$backgroundSet['projectBackground'].")'>";
}
?>
    
    <div class="topIcons">
        <nav class="dropDownMenu">
            <input type="checkbox" id="plusBtn"></input>
            <label class="btn" for="plusBtn">&plus;</label>
            <!--add a form here for the links-->
            <div class="addElemenets">
                <li>
                    <a href="#">Add Image</a>
                    <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileOne" id="fileOne">
                        <label class="input input1" for="fileOne">Choose Image</label>
                        <!--<button type="submit" name="submit-file">Upload Image</button>-->
                        <input class="input input2" type="submit" name="submit-file" value="Upload Image">
                    </form>
                </li>
                <li>
                    <a href="#">Add Video</a>
                    <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileTwo" id="fileTwo">
                        <label class="input input1" for="fileTwo">Choose Video</label>
                        <input class="input input2" type="submit" name="submit-video" value="Upload Video">
                    </form>
                </li>
                <li>
                    <a href="#">Add Audio</a>
                    <form action='includes/upload.inc.php' method='post' enctype='multipart/form-data'>
                        <input type='file' name='fileThree' id="fileThree">
                        <label class="input input1" for="fileThree">Choose Audio</label>
                        <input class="input input2" type='submit' name='submit-audio' value='Upload Audio'>
                    </form>
                </li>
            </div>
        </nav> 

        <nav class="saveNav">
            <form action='includes/dashboard.inc.php' method='post' enctype='multipart/form-data'>
                    <input class="saveBtn" type='submit' value='Save'>
            </form>
        </nav>

        <nav class="settings">
            <input type="checkbox" id="settingsGear"></input>
            <label class="btnGear fa fa-gear" for="settingsGear"></label>
            <li>
                <a href='#'>Change Background Image</a>
                <form action='includes/upload.inc.php' method='post' enctype='multipart/form-data'>
                    <input type='file' name='backgroundImg' id="backgroundImgBtn">
                    <label class="backImgIn backImgIn1" for="backgroundImgBtn">Upload Image</label>
                    <input class="backImgIn backImgIn2" type='submit' name='submit-backgroundImg'>
                </form>
            </li>
        </nav>
    </div>

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
            $filePlace = "SELECT dashboardTop, dashboardLeft, dashboardReWidth, dashboardReHeight, fileType, fileExt FROM dashboard WHERE dashboardUse='$username' AND dashboardProject='$project' AND dashboardOrder=".$_SESSION['dashOrder'].";";
            $fileResult = mysqli_query($conn, $filePlace);
            if(mysqli_num_rows($result)>0){
                $set = mysqli_fetch_assoc($fileResult);

                if($set['fileType'] == "img"){
                    echo "<div id='dashboardImg' class='".$_SESSION['dashOrder']." resizerImg' name='dashboardItem' style='background-image: url(uploadFile/".$row['dashboardFile']."); background-repeat: no-repeat; background-size: 100% 100%; width: 100px; height: 100px; top: ".$set['dashboardTop']."px; left: ".$set['dashboardLeft']."px; width: ".$set['dashboardReWidth']."; height: ".$set['dashboardReHeight']."'>
                        <div class='resizer ne'></div>
                        <div class='resizer nw'></div>
                        <div class='resizer se'></div>
                        <div class='resizer sw'></div>
                    </div>";   
                }elseif($set['fileType'] == "video"){
                    echo "<div id='dashboardVid' class='".$_SESSION['dashOrder']."' name='dashboardItem' style='position: absolute; width: 100px; height: 100px; top: ".$set['dashboardTop']."px; left: ".$set['dashboardLeft']."px; width: ".$set['dashboardReWidth']."; height: ".$set['dashboardReHeight']."'>
                            <video id='vidId' style='width: 100%; height: 100%; z-index: -2;'>
                                <source src='uploadFile/".$row['dashboardFile']."' type='video/".$set['fileExt']."'>
                            </video>
                            <div id='vidBtn' class='btnVideoNum_".$_SESSION['dashOrder']."' name='btnVideoElement' style='z-index: 0; position: absolute; top: 90%;'>Play</div>
                            <div class='resizer ne'></div>
                            <div class='resizer nw'></div>
                            <div class='resizer se'></div>
                            <div class='resizer sw'></div>
                        </div>";
                }elseif($set['fileType'] == "audio"){
                    echo "<div id='dashboardAudio' class='".$_SESSION['dashOrder']."' name='dashboardItem' style='position: absolute; top: ".$set['dashboardTop']."px; left: ".$set['dashboardLeft']."px;'>
                        <audio id='audId' style='z-index: -2'>
                            <source src='uploadFile/".$row['dashboardFile']."' type='audio/".$set['fileExt']."'></source>
                        </audio>
                        <div id='audBtn' class='btnAudioNum_".$_SESSION['dashOrder']."' name='btnAudioElement' sytle='position: absolute; top: 50%; left: 50%; transform: -50%,-50%;'>Play</div>
                    </div>";
                }
            }
        }
    }
    ?>

    
<?php
include_once "footer.php";
?>