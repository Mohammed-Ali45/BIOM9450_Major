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
        header('location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php?error=help');
        exit;
    }else{ //if correct will redirect to the home page
        // Fetch data from the result set
        $row = odbc_fetch_row($exists);
        //set name in session
        // $_SESSION['usersName'] = $row['usersName'];
        $_SESSION['hello'] = $email;
        header('location: http://engpwws005/z5259813$/BIOM9450_Major/patient.php');
        exit;
    }
}
else {
    header("location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php?error=help");
    exit();
}