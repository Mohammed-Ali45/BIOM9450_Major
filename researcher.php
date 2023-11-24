<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Researcher_email'])) {
    $email = $_SESSION['Researcher_email'];
    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);





    //grabbing patient table
    $patient_data_query = "SELECT Patient.[PatientID], Patient.[FirstName], Patient.[LastName], Patient.[icgc_specimen_id] FROM Patient";
    $patient_data_table = odbc_exec($conn, $patient_data_query);
    $patient_data = odbc_fetch_array($patient_data_table);

    $patient_count_query = "SELECT COUNT(*) AS patient_count FROM ($patient_data_query);";
    $patient_count = odbc_result(odbc_exec($conn, $patient_count_query), 'patient_count');

    include_once 'header.php'

        ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <img src="images/snail.jpg" alt="logo" class="logo" width="70" height="70">
                <nav>
                    <ul>
                        <li><a href="researcher.php">Database</a></li>
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
                    <h1>Patient Database</h1>
                    <form>
                        <!-- search bar -->
                        <input type="text" id="searchbar" placeholder="Search Here..." style="width:100%">
                        <!-- category filter -->
                        <select id="category" style="width:100%">
                            <option value="0" selected hidden>Select Category</option>
                            <option value="1">Patient ID</option>
                            <option value="2">ICGC Specimen ID</option>
                            <option value="3">First Name</option>
                            <option value="4">Last Name</option>
                        </select>
                    </form>
                    <button id="newpatient">Add a new patient</button>
                    <table class="tablestyle" id="tbl1">
                        <thead>
                            <tr>
                                <th style="width:15%">Patient ID</th>
                                <th>ICGC Specimen ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php
                            for ($patient_no = 1; ($patient_no - 1) < $patient_count; $patient_no++) {
                                $patient_row = odbc_fetch_array($patient_data_table, $patient_no);
                                echo '<tr>';
                                echo '<td><a href=profile.php>' . $patient_row['PatientID'] . '</a></td>';
                                echo '<td><a href=patient.php onclick= "send_patient_id(this, $patient_no)">' . $patient_row['icgc_specimen_id'] . '</a></td>';
                                echo '<td>' . $patient_row['FirstName'] . '</td>';
                                echo '<td>' . $patient_row['LastName'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
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