<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schoolwork Network</title>
</head>
<body>
    
    <nav>
        <div>
            <?php
            if(!isset($_SESSION['username'])){
                echo "<div>
                        <li><a href='about.php'>About Us</a></li>
                        <li><a href='signup.php'>Sign Up</a></li>
                        <li><a href='login.php'>Login</a></li>
                    </div>";
            }
            else if(isset($_SESSION['username'])){
                echo "<div>
                        <li><a href='#'>Home</a></li>
                        <li><a href='#'>Blog</a></li>
                        <li><a href='#'>Friends</a></li>
                        <li><a href='#'>Settings</a></li>
                        <li><a href='includes/logout.inc.php'>Log Out</a></li>
                    </div>";

                echo "<div>
                        <div>&plus;</div>
                        <form action='includes/create.inc.php' method='post'>
                            <input type='text' name='projectTitle' placeholder='Title'>
                            <input type='text' name='projectDesc' placeholder='Description'>
                            <h3>Choose Color</h3>
                            <select name='bgColor' id='bgColor'>
                                <option value='red'>Red</option>
                                <option value='blue'>Blue</option>
                                <option value='yellow'>Yellow</option>
                                <option value='green'>Green</option>
                            </select>
                            <button type='submit' name='submit-project'>Create</button>
                        </form>
                    </div>";
            }
            ?>
        </div>
    </nav>


    <div>
    