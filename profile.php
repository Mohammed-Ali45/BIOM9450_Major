<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Patient_email'])) {
    $email = $_SESSION['Patient_email'];

    //establish a connection, uncomment your own connection and comment out the other persons

    //Victoria
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);

    //grabbing data from the patient table
    $patient_data_query = "SELECT * FROM Patient WHERE Email = '$email'";
    $patient_data = odbc_exec($conn, $patient_data_query);
    include_once 'header.php'

        ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <div>
                    <img src="images/snail.jpg" alt="logo" class="logo">
                    <div id="logo-text">
                        <span id="cancerictive-text" class="DM-Serif">Cancerictive</span>
                        <br />
                        <span id="slogan-text" class="Lato">Innovation & Compassion</span>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li><a href="patient.php">Mutations</li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="includes/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!--the body section-->
        <div class="container">
            <div class="card-single">
                <div class="card">
                    <div class="row">
                        <div class="column left">
                            <img src="patient-photo/<?php echo 'img_' . odbc_result($patient_data, 'PatientID') ?>.jpg"
                                alt="profile photo" width="200" height="200">
                        </div>
                        <div class="column right">
                            <table class="tablestyle">
                                <tr>
                                    <th colspan="2">Personal Information</th>
                                </tr>
                                <tr>
                                    <td>First Name:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'FirstName'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Name:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'LastName'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'Email'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address:</td> <!--fix the spacing here pls -->
                                    <td>
                                        <?php echo odbc_result($patient_data, 'StreetNumber');
                                        echo odbc_result($patient_data, 'StreetName');
                                        echo odbc_result($patient_data, 'City');
                                        echo odbc_result($patient_data, 'Postcode'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone No.:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'PhoneNo'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Age:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'age'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>
                                        <?php echo odbc_result($patient_data, 'country'); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include_once 'footer.php'
                ?>
            <?php

} else {

    header("Location: index.php");

    exit();

}
?>