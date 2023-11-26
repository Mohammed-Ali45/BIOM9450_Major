<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Researcher_email'])) {
    $email = $_SESSION['Researcher_email'];


    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);





    //grabbing patient table
    $patient_data_query = "SELECT Patient.[PatientID], Patient.[FirstName], Patient.[LastName], Patient.[icgc_specimen_id] FROM Patient";
    $patient_data_table = odbc_exec($conn, $patient_data_query);
    $patient_data = odbc_fetch_array($patient_data_table);

    //Counting the number of rows in the result
    $patient_count_query = "SELECT COUNT(*) AS patient_count FROM ($patient_data_query);";
    $patient_count = odbc_result(odbc_exec($conn, $patient_count_query), 'patient_count');


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
                        <input class="input-type-text bottom-margin" type="text" id="searchbar" placeholder="Search Here..."
                            style="width:100%">
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
                            //Prints all Patient data retreived from above queries
                            for ($patient_no = 1; ($patient_no - 1) < $patient_count; $patient_no++) {
                                $patient_row = odbc_fetch_array($patient_data_table, $patient_no);
                                echo '<tr>';
                                echo '<td><a id=' . "$patient_no" . ' href=session_update.php?patientid=' . $patient_no . '&destination=profile>' . $patient_row['PatientID'] . '</a></td>';
                                echo '<td><a id=' . "$patient_no" . ' href=session_update.php?patientid=' . $patient_no . '&destination=patient>' . $patient_row['icgc_specimen_id'] . '</a></td>';
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
            // This code block retrieves the data for viewing mutations that appear in more than one patient
            // 1st query retrieves all patients and their mutations
            $all_patient_mutations = "SELECT
                                        Patient.PatientID,
                                        Patient.FirstName,
                                        Patient.LastName,
                                        SpecimenMutations.mutationID
                                    INTO
                                        TT_pat_muts
                                    FROM
                                        (
                                            Specimens
                                            INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                                        )
                                        INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]";


            // 2nd query lists the mutations that repeat
            $repeating_mutations_index = "SELECT
                                            SpecimenMutations.mutationID
                                        INTO
                                            TT_rep_muts
                                        FROM
                                            (
                                                Specimens
                                                INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                                            )
                                            INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                                        GROUP BY
                                            SpecimenMutations.mutationID
                                        HAVING
                                            COUNT(SpecimenMutations.mutationID) > 1";


            //1st and 2nd queries are executed
            $patients_mutations = odbc_exec($conn, $all_patient_mutations);
            $repeating_mutations = odbc_exec($conn, $repeating_mutations_index);


            // 3rd query gives the desired table, showing only repeating mutations
            $repeating_mutations = "SELECT
                                TT_rep_muts.mutationID,
                                TT_pat_muts.PatientID,
                                TT_pat_muts.FirstName,
                                TT_pat_muts.LastName
                            FROM
                                (
                                    Mutation
                                    INNER JOIN TT_pat_muts ON Mutation.[mutationID] = TT_pat_muts.[mutationID]
                                )
                                INNER JOIN TT_rep_muts ON Mutation.[mutationID] = TT_rep_muts.[mutationID]
                            ORDER BY
                                TT_rep_muts.mutationID";


            //Execute the last query
            $only_repeating_mutations = odbc_exec($conn, $repeating_mutations);


            //Counting the rows on the 3rd query
            $mutation_count_query = "SELECT COUNT(*) AS mutation_count FROM ($repeating_mutations)";
            $mutation_count = odbc_result(odbc_exec($conn, $mutation_count_query), 'mutation_count');
            ?>

            <div class="card-single">
                <div class="card">
                    <h1>Mutations</h1>
                    <!-- search bar -->
                    <input type="text" id="searchbar_mutation" placeholder="Search Mutation ID..." style="width:100%">
                    <!--Now printing the table produced by the above 3 queries-->
                    <table class="tablestyle" id="tbl2">
                        <thead>
                            <tr>
                                <th style="width:15%">Mutation ID</th>
                                <th>Gene Involved</th>
                                <th>Location</th>
                                <th>Potential Impact</th>
                            </tr>
                        </thead>
                        <tbody id="tbody2">
                            <?php
                            for ($mutation_no = 1; $mutation_no <= $mutation_count; $mutation_no++) {
                                $mutation_row = odbc_fetch_array($only_repeating_mutations, $mutation_no);
                                echo '<tr>';
                                echo '<td>' . $mutation_row['mutationID'] . '</td>';
                                echo ' ';
                                echo '<td>' . $mutation_row['PatientID'] . '</td>';
                                echo '<td>' . $mutation_row['FirstName'] . '</td>';
                                echo '<td>' . $mutation_row['LastName'] . '</td>';
                                echo '</tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            // Releases db lock, end of repeating mutation data retrieval
            $free_result_muts = odbc_free_result($only_repeating_mutations);

            /*Deletes the temporary tables before moving on, allows them to be
            made again on subsquent loads of this page*/
            $delete_TT_pat_muts = odbc_exec($conn, "DROP TABLE TT_pat_muts;");
            $delete_TT_rep_muts = odbc_exec($conn, "DROP TABLE TT_rep_muts;");
            ?>











            <?php
            //This code block retrieves the data for viewing affected genes that appear in more than one patient
            // 1st query retrieves all affected genes in all patients
            $all_affected_genes = "SELECT DISTINCT
                        Patient.PatientID,
                        Patient.FirstName,
                        Patient.LastName,
                        Mutation.gene_affected
                        INTO
                        TT_pat_affgenes
                        FROM
                        (
                            Specimens
                            INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                        )
                        INNER JOIN (
                            Mutation
                            INNER JOIN SpecimenMutations ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
                        ) ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                        WHERE
                        ISNULL(gene_affected) = FALSE
                        ORDER BY
                        Mutation.gene_affected";

            //1st query executed
            $patients_affected_genes = odbc_exec($conn, $all_affected_genes);


            // 2nd query lists all genes that repeat
            $repeating_genes_index = "SELECT
                        Mutation.gene_affected
                        INTO
                        TT_rep_genes
                        FROM
                        pat_genes1
                        GROUP BY
                        Mutation.gene_affected
                        HAVING
                        COUNT(gene_affected) > 1";

            // Executes 2nd query
            $repeating_genes = odbc_exec($conn, $repeating_genes_index);





            /* 3rd query produces the desired table only with repeating genes and
            respective patient data */
            $repeating_affected_genes = "SELECT
                                TT_pat_affgenes.PatientID,
                                TT_pat_affgenes.FirstName,
                                TT_pat_affgenes.LastName,
                                TT_rep_genes.gene_affected
                            FROM
                                TT_pat_affgenes
                            INNER JOIN TT_rep_genes ON TT_pat_affgenes.gene_affected = TT_rep_genes.gene_affected";


            // Executes 3rd query
            $only_repeating_genes = odbc_exec($conn, $repeating_affected_genes);


            // Counts rows in the resulting table
            $gene_count_query = "SELECT COUNT(*) AS gene_count FROM ($repeating_affected_genes)";
            $gene_count = odbc_result(odbc_exec($conn, $gene_count_query), 'gene_count');
            ?>

            <div class = "card-single">
                <div class = "card">
                    <h1>Affected Genes</h1>
                    <!--Prints the table produced in the above 3 queries for repeating affected genes-->
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
                            for ($gene_no = 1; $gene_no <= $gene_count; $gene_no++) {
                                $gene_row = odbc_fetch_array($only_repeating_genes, $gene_no);
                                echo '<tr>';
                                echo '<td>' . $gene_row['gene_affected'] . '</td>';
                                echo ' ';
                                echo '<td>' . $gene_row['PatientID'] . '</td>';
                                echo '<td>' . $gene_row['FirstName'] . '</td>';
                                echo '<td>' . $gene_row['LastName'] . '</td>';
                                echo '</tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php

            // Releases db lock, end of repeating affected gene data retrieval
            $free_muts = odbc_free_result($only_repeating_genes);

            /*Deletes the temporary tables before moving on, allows them to be
            made again on subsquent loads of this page*/
            $delete_TT_pat_affgenes = odbc_exec($conn, "DROP TABLE TT_pat_affgenes;");
            $delete_TT_rep_genes = odbc_exec($conn, "DROP TABLE TT_rep_genes;");
            ?>














    <?php
        include_once 'footer.php'
    ?>
<?php

} else {

    header("Location: index.php");

    exit();

}
?>