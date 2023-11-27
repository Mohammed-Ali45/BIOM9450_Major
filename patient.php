<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Patient_email'])) {
    $email = $_SESSION['Patient_email'];

    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);





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
                                    Mutation.chromosome,
                                    Mutation.chromosome_start,
                                    Mutation.chromosome_end,
                                    Mutation.gene_affected,
                                    Patient.PatientID
                                FROM
                                    (
                                        Specimens
                                        INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                                    )
                                    INNER JOIN (
                                        Mutation
                                        INNER JOIN SpecimenMutations ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
                                    ) ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                                    WHERE PatientID = $patientID
                                ";

    // $mutation_count_query = "SELECT COUNT(*) AS mutation_count FROM ($mutation_profile_query)";
    // $mutation_count = odbc_result(odbc_exec($conn, $mutation_count_query), 'mutation_count');
    $mutation_profile = odbc_exec($conn, $mutation_profile_query);



    //paste the header file
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
                        <input class="input-type-text bottom-margin" type="text" id="searchbar" placeholder="Search Here..."
                            style="width:100%">
                        <!-- category filter -->
                        <select id="category" style="width:100%">
                            <option value="0" selected hidden>Select Category</option>
                            <option value="1">Mutation ID</option>
                            <option value="2">Gene Involved</option>
                            <option value="3">Chromosome</option>
                            <option value="4">Potential Impact</option>
                        </select>
                    </form>

                    <table class="tablestyle collapsable-table" id="tbl1">
                        <!-- <col width="5%">
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="50%"> -->
                        <thead>
                            <tr>
                                <th style="width:15%">Mutation ID</th>
                                <th>Chromosome</th>
                                <th>Start location</th>
                                <th>End Location</th>
                                <th>Gene Affected</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1" class="center-aligned">
                            <?php

                            // Printing all rows of the resulting table
                            $mutation_row = odbc_fetch_array($mutation_profile);
                            $mut_counter = 1;
                            while ($mutation_row != false) {

                                echo '<tr id="mut-row' . $mut_counter . '" onclick="toggle_conseq_row(this.id)">';
                                echo '<td>' . $mutation_row['mutationID'] . '</td>';
                                echo ' ';
                                echo '<td>' . $mutation_row['chromosome'] . '</td>';
                                echo '<td>' . (int) $mutation_row['chromosome_start'] . '</td>';
                                echo '<td>' . (int) $mutation_row['chromosome_end'] . '</td>';
                                echo '<td>' . $mutation_row['gene_affected'] . '</td>';
                                echo '</tr>';

                                $mutation_row = odbc_fetch_array($mutation_profile);


                                // query for consequence types for given mutationID
                                $mut_row = $mutation_row['mutationID'];
                                $consequence_type_query = "SELECT consequence_type
                                                        FROM MutationConsequences
                                                        WHERE mutationID = $mut_row";

                                $consequence_types = odbc_exec($conn, $consequence_type_query);
                                $consequence_types_list = odbc_fetch_array($consequence_types);



                                // Prints all consequence types
                                echo '<tr id="conseq-row' . $mut_counter . '" class="collapsable-row">';
                                echo '<td colspan="3">';
                                while ($consequence_types_list != false) {
                                    echo $consequence_types_list['consequence_type'];
                                    echo '<br/>';
                                    $consequence_types_list = odbc_fetch_array($consequence_types);
                                }

                                echo '</td>';
                                echo '</tr>';

                                $mut_counter++;
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