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
        echo "Please Fill in All Fields";
    }
    else if($_GET['error'] == 'stmtFailed'){
        echo "System Failed Please Try Again";
    }
    else if($_GET['error'] == 'notExistent'){
        echo "Username/Email is not in the System";
    }
    else if($_GET['error'] == 'incorrectPassword'){
        echo "Incorrect Password";
    }
    else if($_GET['error'] == 'none'){
        header("location: index.php");
        exit();
    }
}

?>