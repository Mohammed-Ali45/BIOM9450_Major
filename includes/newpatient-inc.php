<?php
session_start();

//Connection string for allowing workflow to switch between Victoria and Moey's db filepath
include 'conn_string.php';
$conn = conn_string();

// initializing variables
$Fname = "";
$Lname = "";
$age = "";
$dob = "";
$phone_no = "";
$street_no = "";
$street_name = "";
