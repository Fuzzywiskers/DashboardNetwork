<?php
include_once "header.php";
?>

<!--Create Inputs-->
<section>
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeholder="Full Name">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwdRepeate" placeholder="Password Repeate">
        <button type="submit" name="submit">Sign Up</button>
    </form>
</section>

<!--error messages-->

<?php

if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyField'){
        echo "<h3>Please Fill in All Fields</h3>";
    }
    else if($_GET['error'] == 'invalidUse'){
        echo "<h3>Invalid Username</h3>";
    }
    else if($_GET['error'] == 'invalidEmail'){
        echo "<h3>Invalid Email</h3>";
    }
    else if($_GET['error'] == 'passwordNotMatch'){
        echo "<h3>Password Does Not Match</h3>";
    }
    else if($_GET['error'] == 'alreadyExists'){
        echo "<h3>Username/Email Already in System</h3>";
    }
    else if($_GET['error'] == 'stmtFailed'){
        echo "<h3>System Failed Please Try Again</h3>";
    }
    else if($_GET['error'] == 'none'){
        header("location: login.php");
        exit();
    }
}

?>