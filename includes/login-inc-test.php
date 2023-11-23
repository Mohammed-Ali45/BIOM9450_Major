<?php
session_start();

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    /* Connects to database
    1 of the 2 code blocks below should be uncommented according to who is currently running */

    //Victoria
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);

    //Moey
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);

    //Only true when inputted email and password match with a user in db
    $userExists = false;

    //Looks for and retrieves rowdata in db that matches inputted email & password
    $user_data_query = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password' ";

    //Executes above query
    $user_data = odbc_exec($conn, $user_data_query);
    $user_email = odbc_result($user_data, "Email");

    //Retrieves PatientID and StaffID fields from row containing user data
    $patientID = odbc_result($user_data, 'PatientID');
    $staffID = odbc_result($user_data, 'StaffID');

    //checks if above query managed to find match
    if (odbc_fetch_row($user_data, 1)) {
        $userExists = true;
    } else {
        echo $userExists;
        echo $patientID;
        echo $staffID;
        echo odbc_fetch_row($user_data, 1);
    }


    /* Decides where to redirect user.
    Existing users cannot have both a StaffID and PatientID.
    Users with correct login info will be redirected based on that.

    checking for empty inputs and matching users information */
    if (empty($email) || empty($password) || ($userExists == false)) {
        header('location: ../login-test.php?error=help');
        exit;

    } elseif (is_null($patientID) === false && is_null($staffID) === true) {
        $user_data = odbc_exec($conn, $user_data_query);
        $row_data = odbc_fetch_array($user_data);

        //storing email of user in session variable
        $_SESSION['email'] = $row_data['Email'];
        header('location: ../patient.php');
        exit;

    } elseif (is_null($patientID) === true && is_null($staffID) === false) {
        $user_data = odbc_exec($conn, $user_data_query);
        $row_data = odbc_fetch_array($user_data);

        //Query to retrieve occupation of staff, redirect accordingly
        $staff_query = "SELECT
            Users.Email,
            Users.PatientID,
            Users.StaffID,
            Users.Password,
            Staff.Occupation
        FROM
            Staff
            INNER JOIN Users ON Staff.[StaffID] = Users.[StaffID]; ";

        $occupation = odbc_result(odbc_exec($conn, $staff_query), "Occupation");

        if ($occupation == "Researcher") {
            $_SESSION['email'] = $row_data['Email'];
            header('location: ../researcher.php');
            exit;
        } elseif ($occupation == "Oncologist") {
            $_SESSION['email'] = $row_data['Email'];
            header('location: ../oncologist.php');
            exit;
        }

        //storing email of user in session variable
    }

} else {
    header("location: ../login-test.php?error=help");
    exit();
}