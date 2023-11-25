<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Patient_email'])) {
    $email = $_SESSION['Patient_email'];

    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);





    //grabbing data from the patient table
    $patient_data_query = "SELECT * FROM Patient WHERE Email = '$email'";
    $patient_data = odbc_exec($conn, $patient_data_query);
    $patientID = odbc_result($patient_data, 'PatientID');

    //grabbing cancer type for select patient
    $cancertype_query = "SELECT
        Patient.icgc_specimen_id,
        Patient.Email,
        Specimens.[Cancer type]
    FROM
        Specimens
        INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
    WHERE
        Email = '$email';";

    $cancertype = odbc_exec($conn, $cancertype_query);
    $patient_cancertype = odbc_result($cancertype, 'Cancer type');

    //grabbing mutation information for select patient
    $mutation_profile_query = "SELECT
                        Mutation.mutationID,
                        Mutation.gene_affected,
                        Mutation.chromosome,
                        MutationConsequences.consequence_type,
                        SpecimenMutations.icgc_specimen_id,
                        Patient.PatientID
                    FROM
                        (
                            Mutation
                            INNER JOIN (
                                (
                                    Specimens
                                    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                                )
                                INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                            ) ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
                        )
                        INNER JOIN MutationConsequences ON Mutation.[mutationID] = MutationConsequences.[mutationID]
                    WHERE
                        Patient.PatientID = $patientID";

    $mutation_count_query = "SELECT COUNT(*) AS mutation_count FROM ($mutation_profile_query)";
    $mutation_count = odbc_result(odbc_exec($conn, $mutation_count_query), 'mutation_count');
    $mutation_profile = odbc_exec($conn, $mutation_profile_query);

    /*
    for ($mutation_no = 1; $mutation_no < $mutation_count; $mutation_no++) {


    }
    ;
*/
    //paste the header file
    include_once 'header.php'

        ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <img src="images/snail.jpg" alt="logo" class="logo" width="70" height="70">
                <nav>
                    <ul>
                        <li><a href="patient.php">Mutations</a></li>
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
                    <table class="tablestyle">
                        <tr>
                            <th colspan="2">Diagnosis</th>
                        </tr>
                        <tr>
                            <td>Cancer Type</td>
                            <td>
                                <?php echo $patient_cancertype; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Treatment Plan</td>
                            <td>Antibiotics, Chemotherapy</td>
                        </tr>
                    </table>
                    <h1>Mutational Profile</h1>
                    <form>
                        <!-- search bar -->
                        <input type="text" id="searchbar" placeholder="Search Here..." style="width:100%">
                        <!-- category filter -->
                        <select id="category" style="width:100%">
                            <option value="0" selected hidden>Select Category</option>
                            <option value="1">Mutation ID</option>
                            <option value="2">Gene Involved</option>
                            <option value="3">Location</option>
                            <option value="4">Potential Impact</option>
                        </select>
                    </form>

                    <table class="tablestyle" id="tbl1">
                        <thead>
                            <tr>
                                <th style="width:15%">Mutation ID</th>
                                <th>Gene Involved</th>
                                <th>Location</th>
                                <th>Potential Impact</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php
                            for ($mutation_no = 1; $mutation_no <= $mutation_count; $mutation_no++) {
                                $mutation_row = odbc_fetch_array($mutation_profile, $mutation_no);
                                echo '<tr>';
                                echo '<td>' . $mutation_row['mutationID'] . '</td>';
                                echo ' ';
                                echo '<td>' . $mutation_row['gene_affected'] . '</td>';
                                echo '<td>' . $mutation_row['chromosome'] . '</td>';
                                echo '<td>' . $mutation_row['consequence_type'] . '</td>';
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