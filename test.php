<!DOCTYPE html>
<html>

<body>

    <?php
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);
    $sql = "SELECT * FROM RawData";
    $rs = odbc_exec($conn, $sql);

    if (!$conn) {
        exit("Connection Failed: " . $conn);
    } else {
        echo ("Connection Successful!");
    }
    ?>
</body>

</html>