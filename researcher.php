<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Researcher_email'])) {
    $email = $_SESSION['Researcher_email'];



    //Connection string for allowing workflow to switch between Victoria and Moey's db filepath
    include 'conn_string.php';
    $conn = conn_string();




    //grabbing patient table
    $patient_data_query = "SELECT Patient.[PatientID], Patient.[FirstName], Patient.[LastName], Patient.[icgc_specimen_id] FROM Patient";
    $patient_data_table = odbc_exec($conn, $patient_data_query);


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
                <div class="card more-narrowed-padding">
                    <h1>Researcher Dashboard</h1>
                    <p>Welcome to your dashboard. This page will offer you selected filtered views of all mutational
                        profiles of every patient within the Cancerictive database. If you wish to do a more specific query
                        than
                        is offered here, please contact your IT administrator, and they can help you retrieve the
                        data necessary to carry out your work.
                    </p>
                    <br />
                    <p>
                        All tables are search filtered for more precise selections of data, and tables can be accessed by
                        clicking on the relevant dropdowns below. Some tables may contain cells with data in a dark blue
                        font. This designates
                        clickable
                        links that will open a new page to access more data relevant to the selected cell.
                    </p>
                    <br />
                    <br />
                    <p>something</p>
                    <button id="newmut" class="btn">Add a new mutation</button>
                </div>
            </div>









            <!--Patient list table-->
            <div class="card-single">
                <div class="card">
                    <h1 class="show-hide more-narrowed-padding" onclick="show_hide_table(this)"><img class="table-arrow"
                            src="../images/right_arrow.png" />Patient Database</h1>
                    <p class="more-narrowed-padding collapsable">This table lists all Patients currently logged in the
                        Cancerictive
                        Database. All data within the
                        PatientID and ICGC Specimen ID columns consist of hyperlinks that will navigate you to Patient
                        Profiles and their Mutational Profiles respectively.
                        <br />
                        <br />
                    </p>
                    <form>
                        <!-- search bar -->
                        <input class="input-type-text bottom-margin more-narrowed-margin collapsable" type="text"
                            id="searchbar" placeholder="Search Here..." style="width:30%">
                        <!-- category filter -->
                        <select class="select-id-category more-narrowed-margin collapsable" id="category" style="width:30%">
                            <option value="0" selected hidden>Select Category</option>
                            <option value="1">Patient ID</option>
                            <option value="2">ICGC Specimen ID</option>
                            <option value="3">First Name</option>
                            <option value="4">Last Name</option>
                        </select>
                    </form>
                    <button class="btn collapsable more-narrowed-margin" id="newpatient">Add a new patient</button>
                    <table class="tablestyle normal-table collapsable" id="tbl1">
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
                            $patient_no = 1;
                            $patient_row = odbc_fetch_array($patient_data_table);
                            while ($patient_row != false) {

                                echo '<tr>';
                                echo '<td class="center-aligned"><a target="_blank" class="table-hyperlink" id=' . $patient_row['PatientID'] . ' href=session_update.php?patientid=' . $patient_row['PatientID'] . '&destination=profile>' . $patient_row['PatientID'] . '</a></td>';
                                echo '<td class="center-aligned"><a target="_blank" class="table-hyperlink" id=' . $patient_row['PatientID'] . ' href=session_update.php?patientid=' . $patient_row['PatientID'] . '&destination=patient>' . $patient_row['icgc_specimen_id'] . '</a></td>';
                                echo '<td class="center-aligned">' . $patient_row['FirstName'] . '</td>';
                                echo '<td class="center-aligned">' . $patient_row['LastName'] . '</td>';
                                echo '</tr>';


                                $patient_row = odbc_fetch_array($patient_data_table);
                                $patient_no++;
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
            ?>











            <!--Building the mutations table-->
            <div class="card-single">
                <div class="card">
                    <h1 class="show-hide more-narrowed-padding" onclick="show_hide_table(this)"><img class="table-arrow"
                            src="../images/right_arrow.png" />Mutations in >1 Patient</h1>
                    <p class="more-narrowed-padding collapsable">This table lists all mutations stored in the Cancerictive
                        database that appear in more than one patient. It is sorted in numerical order of mutationID, and
                        can be filtered by specific mutationID in the search bar below.
                        <br />
                        <br />
                    </p>

                    <!-- search bar -->
                    <input class="input-type-text bottom-margin more-narrowed-margin collapsable" type="text"
                        id="searchbar_mutation" placeholder="Search Mutation ID..." style="width:30%">
                    <!--Now printing the table produced by the above 3 queries-->
                    <table class="tablestyle normal-table collapsable" id="tbl2">
                        <thead>
                            <tr>
                                <th style="width:15%">Mutation ID</th>
                                <th>Patient ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody class="center-aligned" id="tbody2">
                            <?php

                            $mutation_no = 1;
                            $mutation_row = odbc_fetch_array($only_repeating_mutations);
                            while ($mutation_row != false) {

                                echo '<tr>';
                                echo '<td>' . $mutation_row['mutationID'] . '</td>';
                                echo ' ';
                                echo '<td>' . $mutation_row['PatientID'] . '</td>';
                                echo '<td>' . $mutation_row['FirstName'] . '</td>';
                                echo '<td>' . $mutation_row['LastName'] . '</td>';
                                echo '</tr>';

                                $mutation_row = odbc_fetch_array($only_repeating_mutations);
                                $mutation_no++;
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
                        TT_pat_affgenes.gene_affected
                        INTO
                        TT_rep_genes
                        FROM
                        TT_pat_affgenes
                        GROUP BY
                        TT_pat_affgenes.gene_affected
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
            ?>








            <!-- genes table -->
            <div class="card-single">
                <div class="card">
                    <h1 class="show-hide more-narrowed-padding" onclick="show_hide_table(this)"><img class="table-arrow"
                            src="../images/right_arrow.png" />Affected Genes in >1 Patient</h1>
                    <p class="more-narrowed-padding collapsable">This table lists all affected genes stored in the
                        Cancerictive
                        database that appear in more than one patient. It is sorted in numerical order of the ID of the
                        affected gene, and
                        can be filtered by specific geneID in the search bar below.
                        <br />
                        Mutations occurring in intergenic regions are omitted.
                        <br />
                        <br />
                    </p>

                    <!-- search bar for genes table -->
                    <input class="input-type-text bottom-margin more-narrowed-margin collapsable" type="text"
                        id="searchbar_gene" placeholder="Search Here..." style="width:30%">
                    <!--Prints the table produced in the above 3 queries for repeating affected genes-->
                    <table class="tablestyle normal-table collapsable" id="tbl1">
                        <thead>
                            <tr>
                                <th style="width:15%">Gene Involved</th>
                                <th>Patient ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody class="center-aligned" id="tbody3">
                            <?php
                            $gene_no = 1;
                            $gene_row = odbc_fetch_array($only_repeating_genes);
                            while ($gene_row != false) {

                                echo '<tr>';
                                echo '<td>' . $gene_row['gene_affected'] . '</td>';
                                echo ' ';
                                echo '<td>' . $gene_row['PatientID'] . '</td>';
                                echo '<td>' . $gene_row['FirstName'] . '</td>';
                                echo '<td>' . $gene_row['LastName'] . '</td>';
                                echo '</tr>';

                                $gene_row = odbc_fetch_array($only_repeating_genes);
                                $gene_no++;
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