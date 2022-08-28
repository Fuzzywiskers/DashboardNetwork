<?php
include_once "header.php";
?>

<!--Create Inputs-->
<section>
    <h2>Log In</h2>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="username" placeholder="Username/email">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit" name="submit">Log In</button>
    </form>
</section>

<!--error messages-->

<?php

if(isset($_GET['error'])){
    if($_GET['error'] == 'emptyField'){
        echo "<h3>Please Fill in All Fields</h3>";
    }
    else if($_GET['error'] == 'stmtFailed'){
        echo "<h3>System Failed Please Try Again</h3>";
    }
    else if($_GET['error'] == 'notExistent'){
        echo "<h3>Username/Email is not in the System</h3>";
    }
    else if($_GET['error'] == 'incorrectPassword'){
        echo "<h3>Incorrect Password</h3>";
    }
    else if($_GET['error'] == 'none'){
        header("location: index.php");
        exit();
    }
}

?>