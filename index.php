<?php
include_once "header.php";
?>

<!--About Us-->



<!--Gallery-->

<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $projectOrder = 0;

    include_once "includes/dbh.inc.php";
    $sql = "SELECT projectColor, projectTitle, projectDesc, projectOrder FROM projects WHERE projectUse = '$username'";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "sql statment fail";
    }else{
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while($row = mysqli_fetch_assoc($result)){
            echo "<a href='#'>
                    <div class='project-js project' style='background-color:".$row['projectColor']." ;'>
                        <h2>".$row['projectTitle']."</h2>
                        <p>".$row['projectDesc']."</p>
                    </div>
                  </a>";  
                  
            if($row['projectOrder'] >= $projectOrder){
                $projectOrder++;
                $_SESSION['order'] = $projectOrder;
            }else if(!$row['projectOrder']){
                $_SESSION['order'] = 0;
            }else{
                echo "error: order";
            }
        }
    }
    
}
?>

<?php
include_once "footer.php";
?>