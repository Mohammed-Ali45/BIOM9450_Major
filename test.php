<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_ODBC);
    
    //Moey's db connection
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);


    
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
                        TT_pat_affgenes
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