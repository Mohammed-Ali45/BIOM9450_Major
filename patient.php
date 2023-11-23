<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);
    //grabbing data from the patient table
    $sql = "SELECT * FROM Patient WHERE Email = '$email'";
    $patient_info = odbc_exec($conn, $sql);
    $row = odbc_fetch_array($patient_info);
    $patientID = $row['PatientID'];

    //grabbing cancer type for select patient
    $cancer_stmt = "SELECT Patient.icgc_specimen_id, Patient.Email, Specimens.[Cancer type] FROM Specimens INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id] WHERE Email = '$email'";
    $cancer = odbc_exec($conn, $cancer_stmt);
    $cancer_row = odbc_fetch_array($cancer);

    //
    $mutation_stmt = "SELECT
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
                        Patient.PatientID = '$patientID'";
    $mutation = odbc_exec($conn, $mutation_stmt);
    $mutation_row = odbc_fetch_array($mutation);
    
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
                                <?php echo $cancer_row['Cancer type']; ?>
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
                            <tr>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                            </tr>
                            <tr>
                                <td>Hello</td>
                                <td>Hello</td>
                                <td>Hello</td>
                                <td>Hello</td>
                            </tr>
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