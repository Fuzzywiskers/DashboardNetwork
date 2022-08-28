<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleHead.css">
    <title>Schoolwork Network</title>
</head>
<body>
        <div>
            <?php
            if(!isset($_SESSION['username'])){
                echo "<div class='banner'>
                        "/*<li><a href='about.php'>About Us</a></li>*/."
                        <li><a href='signup.php'>Sign Up</a></li>
                        <li><a href='login.php'>Login</a></li>
                    </div>";
            }
            else if(isset($_SESSION['username'])){
                echo "
                    <input type='checkbox' id='test1'>
                    <label class='btn test1' for='test1'>&plus;</label>
                    <input type='checkbox' id='test2'>
                    <div class='createProBtnDiv'>
                        <label class='btn createProBtn' for='test2'><h4>Create Project</h4></label>
                    </div>
                    <label class='btn createProBtn2' for='test2'><h4>+</h4></label>

                    <div class='cover'></div>
                    <form class='createProForm' action='includes/create.inc.php' method='post'>
                            <input type='text' name='projectTitle' placeholder='Title'>
                            <input type='text' name='projectDesc' placeholder='Description'>
                            <div>
                                <h3>Choose Color</h3>
                                <div class='createIn'>
                                    <select name='bgColor' id='bgColor' class='input'>
                                        <option value='red'>Red</option>
                                        <option value='blue'>Blue</option>
                                        <option value='yellow'>Yellow</option>
                                        <option value='green'>Green</option>
                                    </select>
                                    <button type='submit' name='submit-project' class='input'>Create</button>
                                </div>
                            </div>
                        </form>";

                echo "<nav>
                        <input type='checkbox' id='test3'>
                        <label class='btn test3' for='test3'>&#8801</label>
                        <div>
                            <li><a href='#'>Home</a></li>
                            <li><a href='#'>Blog</a></li>
                            <li><a href='#'>Friends</a></li>
                            <li><a href='#'>Settings</a></li>
                            <li><a href='includes/logout.inc.php'>Log Out</a></li>
                        </div>
                    </nav>";
            
                echo "<h2 class='projectText'>Your Projects</h2>";

                }
            ?>


        </div>
    <div class='projectDiv'>
    