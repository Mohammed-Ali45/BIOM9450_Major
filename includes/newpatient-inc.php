<?php
session_start();

//Connection string for allowing workflow to switch between Victoria and Moey's db filepath
include '../conn_string.php';
$conn = conn_string();




// initializing variables
$Fname = $_POST["Fname"];
$Lname = $_POST["Lname"];
$age = $_POST["age"];
$dob = $_POST["dob"];
$sex = $_POST["sex"];
$phone_no = $_POST["phone_no"];
$email = $_POST["email"];

$street_no = $_POST["street_no"];
$street_name = $_POST["street_name"];
$city = $_POST["city"];
$postcode = $_POST["postcode"];
$country = $_POST["country"];


$cancer_type = $_POST["cancer-type"];
$password = $_POST["password"];


//insert patient query 
$insert_patient_query = "INSERT INTO
Patient (
    FirstName,
    LastName,
    age,
    DOB,
    sex,
    PhoneNo,
    Email,
    StreetNumber,
    StreetName,
    City,
    Postcode,
    country
)
VALUES
(
    '$Fname',
    '$Lname',
    '$age',
    '$dob',
    '$sex',
    '$phone_no',
    '$email',
    '$street_no',
    '$street_name',
    '$city',
    '$postcode',
    '$country'
);";

$insert_patient = odbc_exec($conn, $insert_patient_query);

$count_patient_query = "SELECT COUNT(PatientID) AS patientID_count
FROM Patient;";
$patient_count = odbc_exec($conn, $count_patient_query);
$patient_num = odbc_result($patient_count, 'patientID_count');

//insert user information query
$insert_user_query = "INSERT INTO
Users (
    Email,
    PatientID,
    Password
    )
    VALUES
    (
        '$email',
        '$patient_num',
        '$password'
        
        
    );";

$insert_user = odbc_exec($conn, $insert_user_query);


// Returns staff member to their respective dashboard
if (isset($_SESSION['Researcher_email'])) {
    header("location: ../researcher.php");
} else if (isset($_SESSION['Oncologist_email'])) {
    header("location: ../oncologist.php");
} else {
    header("location: ../login.php");
}