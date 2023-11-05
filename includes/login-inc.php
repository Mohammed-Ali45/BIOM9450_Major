<?php

session_start();

if(isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once 'dbh.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $password) !== false) {
        header("location: ../login-p.php?error=emptyinput");
        exit();
    }

    loginUser($conn,$email,$password);
}
else {
    header("location: ../login-p.php?error=help");
    exit();

}