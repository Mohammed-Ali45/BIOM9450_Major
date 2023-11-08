<?php
session_start();

if(isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    //will the be the connection that will open up the database
    $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 

    //initialize uid = false
    $uidExists = false;

    $sql = "SELECT * FROM users WHERE usersEmail = '$email' AND usersPwd = '$password' ";

    $exists = odbc_exec($conn,$sql);

    if(odbc_fetch_row($exists)){ //if the email and password exist in the same row then the user 
        $uidExists = true; //change uid = true
    }

    if (empty($email) || empty($password) || ($uidExists == false)) { //checking for empty inputs and matching users information
        header('location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php');
        exit;
    }else{ //if correct will redirect to the index page
       header('location: http://engpwws005/z5259813$/BIOM9450_Major/index.php');
       exit;
    }
}
else {
    header("location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php?error=help");
    exit();
}