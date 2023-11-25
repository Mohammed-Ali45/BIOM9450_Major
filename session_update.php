<?php

session_start();
//Moey's db connection
$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);


//Gets PatientID from URL
$patient_id = $_GET['patientid'];

$patient_data_query = "SELECT * FROM Patient WHERE PatientID = $patient_id";
$patient_data = odbc_exec($conn, $patient_data_query);
$patient_email = odbc_result($patient_data, 'Email');



$_SESSION['Patient_email'] = $patient_email;


// The switchboard
if ($_GET['destination'] == 'profile') {
    header('location: /profile.php');
    exit;
} else if ($_GET['destination'] == 'patient') {
    header('location: /patient.php');
    exit;
}
