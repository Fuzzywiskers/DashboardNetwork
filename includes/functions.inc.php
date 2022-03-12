<?php

/*Sign Up*/
function emptyFieldSignup($name, $email, $username, $pwd, $pwdRepeate){
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeate)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidUse($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeate){
    $result;
    if($pwd !== $pwdRepeate){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function useExist($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUse=? or usersEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

}

function createUser($conn, $name, $email, $username, $pwd){
    $sql = "INSERT INTO users (usersName, usersEmail, usersUse, usersPwd) VALUE (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}


/*Log In*/
function emptyFieldLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
}

function loginUser($conn, $username, $pwd){
    $useExist = useExist($conn, $username, $username);
    if($useExist === false){
        header("location: ../login.php?error=notExistent");
        exit();
    }

    /*password*/
    $pwdHashed = $useExist['usersPwd'];
    $checkPwd = password_verify($pwd, $pwdHashed);
    if($checkPwd === false){
        header("location: ../login.php?error=incorrectPassword");
        exit();
    }
    else{
        session_start();
        $_SESSION['username'] = $useExist['usersUse'];
        $_SESSION['userId'] = $useExist['usersId'];
        header("location: ../login.php?error=none");
        exit();
    }

}


/*uploads*/
function emptyFieldProject($title, $description){
    $result;
    if(empty($title) || empty($description)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}


function createProject($conn, $use, $title, $desc, $color, $order){
    $sql = "INSERT INTO projects (projectUse, projectTitle, projectDesc, projectColor, projectOrder) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    /*replace placeholders*/
    mysqli_stmt_bind_param($stmt, "sssss", $use, $title, $desc, $color, $order);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../index.php?error=none1");
    exit();

}