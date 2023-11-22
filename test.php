<!DOCTYPE html>
<html>

<body>

    <?php
    // $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);
    $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);
    $sql = "SELECT * FROM RawData";
    $rs = odbc_exec($conn, $sql);

    if (!$conn) {
        exit("Connection Failed: " . $conn);
    } else {
        echo ("Connection Successful!");
    }
    ?>

<?php session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);

    if (!$conn) {
        echo "ODBC connection failed: " . odbc_errormsg();
        exit;
    }

    $sql = "SELECT * FROM Patient WHERE Email = '$email'";
    $exists = odbc_exec($conn, $sql);

    if (!$exists) {
        echo "Query execution failed: " . odbc_errormsg($conn);
        exit;
    }

    $row = odbc_fetch_array($exists);

    if (!$row) {
        echo "No data found for email: $email";
        exit;
    }

    // Now you can echo both $email and data from $row
    echo "Email from session: $email";
    echo "Email from database row: " . $row['Email'];
} else {
    echo "Email not set in session.";
}
echo $row['Photo'];
?>


</body>

</html>