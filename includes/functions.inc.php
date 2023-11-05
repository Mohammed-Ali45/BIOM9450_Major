<?php

function emptyInputLogin($email,$password) {
    $result=null;
    if (empty($email) || empty($password)) {
        $result=true;
    }
    else {
        $result=false;
    }
    return $result;

}

function uidExists($conn, $email, $password) {
    $sql = "SELECT * FROM users WHERE usersEmail = ? and usersPwd = ?";
    $stmt = odbc_prepare($conn, $sql);

    if (!$stmt) {
        die("ODBC prepare failed: " . odbc_errormsg($conn));
    }

    if (odbc_execute($stmt, array($email, $password))) {
        if (odbc_fetch_row($stmt)) {
            return true; // User exists
        }
    }

    return false; //User does not exist
}

function loginUser($conn,$email,$password) {
    $uidExists = uidExists($conn, $email, $password);

    if ($uidExists === false)
        header("location: ../login-p.php?error=wronglogin");
        exit();

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($password, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login-p.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["usersid"] = $uidExists["usersID"];
        $_SESSION["usersuid"] = $uidExists["usersUid"];
        header("location: ../index.php");
        exit();
    }
}

include "dbh.php";

if(isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data) {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
}

$email = validate($_POST['email']);
$password = validate($_POST['password']);

if(empty($email)) {
    header("location: ../login-p.php?error=emptyemail");
    exit();
}
else if(empty($password)) {
    header("location: ../login-p.php?error=password");
    exit();
}

$sql = "SELECT * FROM users WHERE usersEmail='$email' AND usersPwd='$password'";
$result = odbc_exec($conn, $sql);



if (odbc_num_rows($result) === 1) {
    $row = odbc_fetch_array($result);

    if ($row['usersEmail'] === $email && $row['usersPwd'] === $password) {

        echo "Logged in!";

        $_SESSION['usersEmail'] = $row['usersEmail'];

        $_SESSION['usersName'] = $row['usersName'];

        $_SESSION['UsersId'] = $row['UsersId'];

        header("Location: index.php");

        exit();

    }else{

        header("Location: ../login-p.php?error=Incorect Email or password");

        exit();
    }

}
else{
    header("location: ../login-p.php?error=help");
    exit();

}