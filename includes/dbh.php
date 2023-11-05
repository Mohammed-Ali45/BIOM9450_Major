<?php

//will the be the connection that will open up the database
$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);
if(!$conn){
    exit("Connection Failed:". $conn);
}
else{
    echo "Connection Successful";
} 