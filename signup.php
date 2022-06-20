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
        echo "Please Fill in All Fields";
    }
    else if($_GET['error'] == 'invalidUse'){
        echo "Invalid Username";
    }
    else if($_GET['error'] == 'invalidEmail'){
        echo "Invalid Email";
    }
    else if($_GET['error'] == 'passwordNotMatch'){
        echo "Password Does Not Match";
    }
    else if($_GET['error'] == 'alreadyExists'){
        echo "Username/Email Already in System";
    }
    else if($_GET['error'] == 'stmtFailed'){
        echo "System Failed Please Try Again";
    }
    else if($_GET['error'] == 'none'){
        header("location: ../index.php");
        exit();
    }
}

?>