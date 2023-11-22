<?php
session_start();

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    /*will the be the connection that will open up the database 
    1 of the 3 code blocks below should be uncommented according to who is currently running */

    //Victoria
    $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);
    

    //Moey
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);

    //initialize uid = false
    $uidExists = false;

    $sql = "SELECT * FROM Users WHERE Email = '$email' AND Passwords = '$password' ";

    $exists = odbc_exec($conn, $sql);

    if (odbc_fetch_row($exists)) { //if the email and password exist in the same row then the user 
        $uidExists = true; //change uid = true
    }

    if (empty($email) || empty($password) || ($uidExists == false)) { //checking for empty inputs and matching users information
        //header('location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php?error=help');
        header('location: ../login-p.php?error=help');
        exit;
    } else { //if correct will redirect to the home page
        $exists = odbc_exec($conn, $sql);
        $row = odbc_fetch_array($exists);

        //storing email of the user in the session variable
        //$_SESSION['username'] = $row['usersName'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['patientID'] = $row['PatientID'];
        //header('location: http://engpwws005/z5259813$/BIOM9450_Major/patient.php');
        header('location: ../patient.php');
        exit;
    }
} else {
    //header("location: http://engpwws005/z5259813$/BIOM9450_Major/login-p.php?error=helppls");
    header("location: ../login-p.php?error=help");
    exit();
}